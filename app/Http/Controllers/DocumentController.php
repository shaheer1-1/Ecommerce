<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use App\Models\Product;
class DocumentController extends Controller
{
    public function secureDocumentDownload($type, $id, $action)
    {
        $documentTypes = [
            'user-profile-image'       => [\App\Models\User::class, 'profile_image'],
            'category-image'       => [\App\Models\Category::class, 'image'],
            'product-image'       => [\App\Models\Product::class, 'image'],
        ];

        return $this->handleDocumentDownload($type, $id, $action, $documentTypes);
    }

    public function secureUnauthDocumentDownload($type, $id, $action)
    {
        $documentTypes = [
            'user-profile-image'       => [\App\Models\User::class, 'profile_image'],
            'category-image'       => [\App\Models\Category::class, 'image'],
            'product-image'       => [\App\Models\Product::class, 'image'],

        ];

        return $this->handleDocumentDownload($type, $id, $action, $documentTypes);
    }

    private function handleDocumentDownload($type, $id, $action, array $documentTypes)
    {
        if (!isset($documentTypes[$type])) {
            return abort(400, 'Unsupported document type.');
        }

        [$model, $attribute] = $documentTypes[$type];
        $doc = $model::find($id);
        if (!$doc) {
            return abort(404, 'Document not found.');
        }

        $filePath = $doc?->$attribute;

        if (!$filePath || !Storage::exists($filePath)) {
            return abort(404, 'Document not found.');
        }

        $mimeType = Storage::mimeType($filePath) ?? 'application/octet-stream';
        $filename = basename($filePath);

        if (config('filesystems.default') === 's3') {
            $temporaryUrl = Storage::temporaryUrl($filePath, now()->addMinutes(5));

            return match ($action) {
                'download' => redirect($temporaryUrl),
                'view'     => redirect($temporaryUrl),
                default    => abort(400, 'Unsupported action.'),
            };
        }

        $stream = Storage::readStream($filePath);

        return match ($action) {
            'download' => response()->streamDownload(fn() => fpassthru($stream), $filename),
            'view'     => response()->stream(fn() => fpassthru($stream), 200, [
                'Content-Type' => $mimeType,
                'Content-Disposition' => "inline; filename=\"$filename\""
            ]),
            default    => abort(400, 'Unsupported action.'),
        };
    }
}
