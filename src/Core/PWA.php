<?php

namespace FrancisLarvelPwa\Core;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\ValidationException;

class PWA
{
    /**
     * Process the uploaded logo.
     */
    public static function processLogo(Request $request): array
    {
        try {
            $request->validate([
                'logo' => 'required|image|mimes:png|dimensions:min_width=512,min_height=512|max:1024',
            ]);

            $destinationPath = public_path('logo.png');

            if (File::exists($destinationPath)) {
                File::delete($destinationPath);
            }

            $request->file('logo')->move(public_path(), 'logo.png');

            return [
                'status' => true,
                'message' => 'Logo updated successfully!',
                'path' => asset('logo.png'),
            ];

        } catch (ValidationException $e) {
            return [
                'status' => false,
                'errors' => $e->errors(),
            ];

        } catch (\Exception $e) {
            return [
                'status' => false,
                'error' => 'Something went wrong. Please try again.',
            ];
        }
    }
}