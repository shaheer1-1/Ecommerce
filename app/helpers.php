<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

if (! function_exists('ensureUserHasRole')) {
    function ensureUserHasRole(string $role)
    {
        $user = Auth::user();
        return $user !== null && ($user->type ?? '') === $role;
    }
}
if (! function_exists('getHeaderCart')) {
function getHeaderCart()
{
                    $headerCart = ensureUserHasRole('user')
                        ? auth()->user()->cart()->with('items.product')->first()
                        : null;
                
                    $headerItems = $headerCart ? $headerCart->items : collect();
                
                    $headerQty = $headerItems->sum('quantity');
                
                    $headerTotal = $headerItems->sum(fn($row) => $row->quantity * $row->price);
    return [
        'cart' => $headerCart,
        'items' => $headerItems,
        'qty' => $headerQty,
        'total' => $headerTotal
    ];
}
}
function getFileName_uniq($filePath, $filename)
{
    while (true) {

        if (file_exists($filePath . "" . $filename)) {
            $parts = explode(".", $filename);
            $last = count($parts) - 1;
            $ext = $parts[$last];
            $fileFname = basename($filename, "." . $ext);
            $parts2 = explode("_", $fileFname);
            $last2 = count($parts2) - 1;
            $partsnum = $parts2[$last2];

            if ((int)$partsnum == 0) {
                $filename = $fileFname . "_" . uniqid() . "." . $ext;
            } else {
                $nen = basename($fileFname, "_" . $partsnum);
                $newNu = (int)$partsnum + 1;
                $filename = $nen . "_" . $newNu . "." . $ext;
            }
        } else {
            $filename = str_replace(" ", "_", $filename);
            if (file_exists($filePath . "" . $filename)) {
                $parts = explode(".", $filename);
                $last = count($parts) - 1;
                $ext = $parts[$last];
                $fileFname = basename($filename, "." . $ext);
                $parts2 = explode("_", $fileFname);
                $last2 = count($parts2) - 1;
                $partsnum = $parts2[$last2];

                if ((int)$partsnum == 0) {
                    $filename = $fileFname . "_" . uniqid() . "." . $ext;
                } else {
                    $nen = basename($fileFname, "_" . $partsnum);
                    $newNu = (int)$partsnum + 1;
                    $filename = $nen . "_" . $newNu . "." . $ext;
                }
            }
            return str_replace(' ', '-', $filename);
            break;
        }
    }
    return str_replace(' ', '-', $filename);
}
