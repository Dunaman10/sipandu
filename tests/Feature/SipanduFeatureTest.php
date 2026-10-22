<?php

namespace Tests\Feature;

use App\Models\ClusteringSession;
use App\Models\KasWarga;
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

    public function test_kas_warga_index_and_toggle_status(): void
    {
        $response = $this->actingAs($this->bendahara)->get('/kas');
        $response->assertStatus(200);

        $kas = KasWarga::first();
        if ($kas) {
            $toggleResponse = $this->actingAs($this->bendahara)->patch('/kas/' . $kas->id . '/toggle-status');
            $toggleResponse->assertSessionHas('success');
        }
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

    public function test_ronda_index_and_rekapitulasi(): void
    {
        $response = $this->actingAs($this->ketuaRt)->get('/ronda');
        $response->assertStatus(200);

        $rekapResponse = $this->actingAs($this->ketuaRt)->get('/ronda/rekapitulasi');
        $rekapResponse->assertStatus(200);
    }

    public function test_pdf_exports_render_successfully(): void
    {
        $wargaPdf = $this->actingAs($this->ketuaRt)->get('/warga/export-pdf');
        $wargaPdf->assertStatus(200);

        $kasPdf = $this->actingAs($this->bendahara)->get('/kas/export-pdf');
        $kasPdf->assertStatus(200);

        $rondaPdf = $this->actingAs($this->ketuaRt)->get('/ronda/export-pdf');
        $rondaPdf->assertStatus(200);
    }
}
