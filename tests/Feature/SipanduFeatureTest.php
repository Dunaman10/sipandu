<?php

namespace Tests\Feature;

use App\Models\ClusteringSession;
use App\Models\RondaParticipant;
use App\Models\RondaSchedule;
use App\Models\User;
use App\Models\Warga;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SipanduFeatureTest extends TestCase
{
    use RefreshDatabase;

    protected User $admin;
    protected User $ketuaRt;
    protected User $bendahara;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);

        $this->admin = User::where('role', 'admin')->first();
        $this->ketuaRt = User::where('role', 'ketua_rt')->first();
        $this->bendahara = User::where('role', 'bendahara')->first();
    }

    public function test_login_page_renders_successfully(): void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('SIPANDU RT 03');
    }

    public function test_user_can_login_with_username(): void
    {
        $response = $this->post('/login', [
            'login' => 'admin',
            'password' => 'password',
        ]);

        $response->assertRedirect('/dashboard');
        $this->assertAuthenticatedAs($this->admin);
    }

    public function test_dashboard_renders_for_authenticated_users(): void
    {
        $response = $this->actingAs($this->ketuaRt)->get('/dashboard');
        $response->assertStatus(200);
        $response->assertSee('SIPANDU');
        $response->assertSee('Total Warga');
    }

    public function test_warga_index_and_create_work(): void
    {
        $response = $this->actingAs($this->ketuaRt)->get('/warga');
        $response->assertStatus(200);

        $createResponse = $this->actingAs($this->ketuaRt)->get('/warga/create');
        $createResponse->assertStatus(200);
    }

    public function test_fitur_kas_sudah_dihapus_sesuai_batasan_skripsi(): void
    {
        // Batasan Penelitian (Skripsi 1.5): data terbatas pada identitas dasar, usia, dan status ekonomi.
        $this->actingAs($this->bendahara)->get('/kas')->assertNotFound();
        $this->actingAs($this->admin)->get('/kas/export-pdf')->assertNotFound();

        $dashboard = $this->actingAs($this->admin)->get('/dashboard');
        $dashboard->assertStatus(200);
        $dashboard->assertDontSee('Kas RT');
        $dashboard->assertSee('Sebaran Kelompok Usia Warga');
        $dashboard->assertSee('Kelengkapan KTP Warga');
    }

    public function test_bendahara_dapat_melihat_data_warga_dan_cetak_laporan(): void
    {
        $this->actingAs($this->bendahara)->get('/warga')->assertStatus(200);
        $this->actingAs($this->bendahara)->get('/warga/export-pdf')->assertStatus(200);
    }

    public function test_clustering_index_and_run(): void
    {
        $response = $this->actingAs($this->ketuaRt)->get('/clustering');
        $response->assertStatus(200);

        $runResponse = $this->actingAs($this->ketuaRt)->post('/clustering/run');
        $runResponse->assertRedirect();

        $session = ClusteringSession::first();
        $this->assertNotNull($session);

        $showResponse = $this->actingAs($this->ketuaRt)->get('/clustering/' . $session->id);
        $showResponse->assertStatus(200);
        $showResponse->assertSee($session->kode_sesi);
    }

    public function test_ronda_index_and_generate_otomatis(): void
    {
        $response = $this->actingAs($this->ketuaRt)->get('/ronda');
        $response->assertStatus(200);
        $response->assertSee('Jadwal Ronda Malam');

        $generateResponse = $this->actingAs($this->ketuaRt)->post('/ronda/generate-otomatis', [
            'tanggal_mulai' => date('Y-m-d'),
            'jumlah_hari' => 3,
            'petugas_per_malam' => 4,
            'shift_ronda' => 'Malam (22:00 - 04:00)',
        ]);
        $generateResponse->assertRedirect('/ronda');
        $generateResponse->assertSessionHas('success');
    }

    public function test_pdf_exports_render_successfully(): void
    {
        $wargaPdf = $this->actingAs($this->ketuaRt)->get('/warga/export-pdf');
        $wargaPdf->assertStatus(200);

        $rondaPdf = $this->actingAs($this->ketuaRt)->get('/ronda/export-pdf');
        $rondaPdf->assertStatus(200);
    }

    public function test_excel_exports_download_successfully(): void
    {
        $wargaExcel = $this->actingAs($this->ketuaRt)->get('/warga/export-excel');
        $wargaExcel->assertStatus(200);
        $wargaExcel->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $rondaExcel = $this->actingAs($this->ketuaRt)->get('/ronda/export-excel');
        $rondaExcel->assertStatus(200);
        $rondaExcel->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        $session = ClusteringSession::first();
        if ($session) {
            $clusteringExcel = $this->actingAs($this->ketuaRt)->get('/clustering/' . $session->id . '/export-excel');
            $clusteringExcel->assertStatus(200);
            $clusteringExcel->assertHeader('content-type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        }
    }

    public function test_bendahara_cannot_access_warga_create_or_clustering_or_user_management(): void
    {
        // PRD Section 2: Bendahara hanya melihat daftar warga, tidak mengelola (tambah/edit/hapus)
        $wargaCreate = $this->actingAs($this->bendahara)->get('/warga/create');
        $wargaCreate->assertStatus(403);

        // PRD Section 2: Clustering adalah hak akses Ketua RT & Admin
        $clustering = $this->actingAs($this->bendahara)->get('/clustering');
        $clustering->assertStatus(403);

        // PRD Section 2: Kelola user adalah hak akses Admin Superadmin
        $users = $this->actingAs($this->bendahara)->get('/pengguna');
        $users->assertStatus(403);
    }

    public function test_ketua_rt_cannot_access_user_management(): void
    {
        // PRD Section 2: Kelola user (CRUD User) hanya untuk Admin Superadmin
        $response = $this->actingAs($this->ketuaRt)->get('/pengguna');
        $response->assertStatus(403);
    }

    public function test_admin_superadmin_has_full_access(): void
    {
        $this->actingAs($this->admin)->get('/dashboard')->assertStatus(200);
        $this->actingAs($this->admin)->get('/warga')->assertStatus(200);
        $this->actingAs($this->admin)->get('/warga/create')->assertStatus(200);
        $this->actingAs($this->admin)->get('/pengguna')->assertStatus(200);
    }

    public function test_sidebar_has_direct_links_without_submenus(): void
    {
        $response = $this->actingAs($this->admin)->get('/dashboard');
        $response->assertStatus(200);

        // Pastikan link menu utama langsung mengarah ke index halaman
        $response->assertSee(route('dashboard'));
        $response->assertSee(route('warga.index'));
        $response->assertSee(route('clustering.index'));
        $response->assertSee(route('ronda.index'));
        $response->assertSee(route('pengguna.index'));

        // Pastikan tidak ada class dropdown atau arrow submenu di sidebar
        $response->assertDontSee('menu-dropdown');
        $response->assertDontSee('menu-item-arrow');
    }
}

