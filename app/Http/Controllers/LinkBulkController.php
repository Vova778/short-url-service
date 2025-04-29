<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Link;

class LinkBulkController extends Controller
{
    public function bulkForm()
    {
        return view('links.bulk');
    }

    public function bulkProcess(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);

        [$pairs, $invalidCount] = $this->parseBulkFile($request->file('file'));

        $filename = 'bulk_shortened_' . time() . '.xlsx';
        $path = storage_path('app/public/' . $filename);
        $data = array_merge([['Original URL', 'Short URL']], $pairs);
        \Shuchkin\SimpleXLSXGen::fromArray($data)->saveAs($path);

        return response()->json([
            'download_url' => route('links.bulk.download', $filename),
            'total' => count($pairs),
            'invalid' => $invalidCount,
        ]);
    }

    protected function parseBulkFile($file): array
    {
        $xlsx = \Shuchkin\SimpleXLSX::parse($file->getRealPath());
        $pairs = [];
        $invalidCount = 0;

        foreach ($xlsx->rows() as $row) {
            $orig = trim($row[0] ?? '');
            if ($orig === '') continue;

            if (filter_var($orig, FILTER_VALIDATE_URL)) {
                try {
                    $code = Link::generateUniqueCode();
                    Link::create([
                        'original_url' => $orig,
                        'short_code' => $code,
                        'user_id' => optional(request()->user())->id,
                    ]);
                    $short = route('links.redirect', $code);
                } catch (\Throwable $e) {
                    $short = __('links.bulk.error');
                    $invalidCount++;
                }
            } else {
                $short = 'Invalid URL';
                $invalidCount++;
            }
            $pairs[] = [$orig, $short];
        }

        return [$pairs, $invalidCount];
    }


    public function bulkDownload(string $filename)
    {
        $path = storage_path("app/public/{$filename}");

        if (!file_exists($path)) {
            abort(404, __('links.bulk.error_file_not_found'));
        }

        return response()
            ->download($path, $filename)
            ->deleteFileAfterSend(true);
    }
}
