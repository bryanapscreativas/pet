<?php

namespace App\Http\Controllers\Api;

use App\Models\NfcCode;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NfcController extends Controller
{
    public function findNfc(string $ulid): JsonResponse
    {
        $nfc = NfcCode::where('ulid', $ulid)->firstOrFail();

        return response()->json([
            'ulid' => $nfc->ulid,
            'used' => !is_null($nfc->user_id),
            'user_id' => $nfc->user_id,
        ]);
    }

    public function assignNfc(Request $request): JsonResponse
    {
        $request->validate([
            'ulid' => 'required|exists:nfc_codes,ulid',
        ]);
    
        $nfc = NfcCode::where('ulid', $request->ulid)->first();

        if (!$nfc->user_id) {
            $nfc->user_id = Auth::id();
            $nfc->used_at = now();
            $nfc->save();
        }
    
        return response()->json(['message' => 'NFC asignado.']);
    }
}
