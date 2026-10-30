<?php

namespace App\Services;

use ZipArchive;

class SimpleXlsxExporter
{
    /**
     * Generate an XLSX file from tabular data and stream it as an HTTP download response.
     *
     * @param string $filename e.g. "Data_Warga_RT03.xlsx"
     * @param string $sheetTitle e.g. "Data Warga"
     * @param array<int, string> $headers e.g. ['No', 'Nama Lengkap', 'NIK']
     * @param array<int, array<int, mixed>> $rows e.g. [[1, 'Ahmad', '327401...']]
     */
    public static function download(string $filename, string $sheetTitle, array $headers, array $rows)
    {
        $tmpFile = tempnam(sys_get_temp_dir(), 'xlsx_');
        unlink($tmpFile); // remove 0-byte file to prevent PHP 8.3 deprecation warning

        $zip = new ZipArchive();
        if ($zip->open($tmpFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
            throw new \RuntimeException('Gagal membuat file arsip XLSX.');
        }

        // [Content_Types].xml
        $contentTypes = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Types xmlns="http://schemas.openxmlformats.org/package/2006/content-types">'
            . '<Default Extension="rels" ContentType="application/vnd.openxmlformats-package.relationships+xml"/>'
            . '<Default Extension="xml" ContentType="application/xml"/>'
            . '<Override PartName="/xl/workbook.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet.main+xml"/>'
            . '<Override PartName="/xl/worksheets/sheet1.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.worksheet+xml"/>'
            . '<Override PartName="/xl/styles.xml" ContentType="application/vnd.openxmlformats-officedocument.spreadsheetml.styles+xml"/>'
            . '</Types>';
        $zip->addFromString('[Content_Types].xml', $contentTypes);

        // _rels/.rels
        $rootRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/officeDocument" Target="xl/workbook.xml"/>'
            . '</Relationships>';
        $zip->addFromString('_rels/.rels', $rootRels);

        // xl/workbook.xml
        $cleanSheetTitle = htmlspecialchars(mb_substr($sheetTitle, 0, 31), ENT_XML1, 'UTF-8');
        $workbook = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<workbook xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main" xmlns:r="http://schemas.openxmlformats.org/officeDocument/2006/relationships">'
            . '<sheets>'
            . '<sheet name="' . $cleanSheetTitle . '" sheetId="1" r:id="rId1"/>'
            . '</sheets>'
            . '</workbook>';
        $zip->addFromString('xl/workbook.xml', $workbook);

        // xl/_rels/workbook.xml.rels
        $wbRels = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<Relationships xmlns="http://schemas.openxmlformats.org/package/2006/relationships">'
            . '<Relationship Id="rId1" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/worksheet" Target="worksheets/sheet1.xml"/>'
            . '<Relationship Id="rId2" Type="http://schemas.openxmlformats.org/officeDocument/2006/relationships/styles" Target="styles.xml"/>'
            . '</Relationships>';
        $zip->addFromString('xl/_rels/workbook.xml.rels', $wbRels);

        // xl/styles.xml
        $styles = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<styleSheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<fonts count="2">'
            . '<font><sz val="10"/><name val="Arial"/></font>'
            . '<font><b/><sz val="10"/><color rgb="FFFFFFFF"/><name val="Arial"/></font>'
            . '</fonts>'
            . '<fills count="3">'
            . '<fill><patternFill patternType="none"/></fill>'
            . '<fill><patternFill patternType="gray125"/></fill>'
            . '<fill><patternFill patternType="solid"><fgColor rgb="FF1F2937"/></patternFill></fill>'
            . '</fills>'
            . '<borders count="2">'
            . '<border><left/><right/><top/><bottom/><diagonal/></border>'
            . '<border><left style="thin"/><right style="thin"/><top style="thin"/><bottom style="thin"/></border>'
            . '</borders>'
            . '<cellStyleXfs count="1">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="0"/>'
            . '</cellStyleXfs>'
            . '<cellXfs count="2">'
            . '<xf numFmtId="0" fontId="0" fillId="0" borderId="1" xfId="0" applyBorder="1"/>'
            . '<xf numFmtId="0" fontId="1" fillId="2" borderId="1" xfId="0" applyFont="1" applyFill="1" applyBorder="1"/>'
            . '</cellXfs>'
            . '</styleSheet>';
        $zip->addFromString('xl/styles.xml', $styles);

        // xl/worksheets/sheet1.xml
        $sheetXml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>'
            . '<worksheet xmlns="http://schemas.openxmlformats.org/spreadsheetml/2006/main">'
            . '<sheetData>';

        $rowIndex = 1;

        // Header row (style index 1 = bold white on dark)
        $sheetXml .= '<row r="' . $rowIndex . '">';
        foreach ($headers as $colIndex => $headerText) {
            $colLetter = self::columnIndexToLetter($colIndex + 1);
            $cellRef = $colLetter . $rowIndex;
            $valEscaped = htmlspecialchars((string) $headerText, ENT_XML1, 'UTF-8');
            $sheetXml .= '<c r="' . $cellRef . '" t="inlineStr" s="1"><is><t>' . $valEscaped . '</t></is></c>';
        }
        $sheetXml .= '</row>';

        // Data rows (style index 0 = normal border)
        foreach ($rows as $row) {
            $rowIndex++;
            $sheetXml .= '<row r="' . $rowIndex . '">';
            $colIndex = 1;
            foreach ($row as $cellVal) {
                $colLetter = self::columnIndexToLetter($colIndex);
                $cellRef = $colLetter . $rowIndex;

                if (is_int($cellVal) || (is_numeric($cellVal) && !preg_match('/^0\d+/', (string) $cellVal) && strlen((string)$cellVal) < 15)) {
                    // numeric cell
                    $sheetXml .= '<c r="' . $cellRef . '" s="0"><v>' . $cellVal . '</v></c>';
                } else {
                    // string cell (NIK, KK, labels)
                    $valEscaped = htmlspecialchars((string) ($cellVal ?? ''), ENT_XML1, 'UTF-8');
                    $sheetXml .= '<c r="' . $cellRef . '" t="inlineStr" s="0"><is><t>' . $valEscaped . '</t></is></c>';
                }
                $colIndex++;
            }
            $sheetXml .= '</row>';
        }

        $sheetXml .= '</sheetData></worksheet>';
        $zip->addFromString('xl/worksheets/sheet1.xml', $sheetXml);

        $zip->close();

        return response()->download($tmpFile, $filename, [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Cache-Control' => 'no-cache, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ])->deleteFileAfterSend(true);
    }

    /**
     * Convert 1-based column index to letter (1 -> A, 27 -> AA, etc.)
     */
    private static function columnIndexToLetter(int $colIndex): string
    {
        $letter = '';
        while ($colIndex > 0) {
            $mod = ($colIndex - 1) % 26;
            $letter = chr(65 + $mod) . $letter;
            $colIndex = (int) (($colIndex - $mod) / 26);
        }
        return $letter;
    }
}

