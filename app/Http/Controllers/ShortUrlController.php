<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ShortUrl;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ShortUrlController extends Controller
{
    public function index()
    {
        if (auth()->user()->is_admin) {
            $urls = ShortUrl::select('short_urls.*', DB::raw("CONCAT(users.firstname, ' ', users.lastname) as user_full_name"))
                ->leftJoin('users', 'short_urls.created_by', '=', 'users.id')
                ->paginate(5);

            return view('admin.shorten', compact('urls'));
        } else {
            $urls = ShortUrl::where('created_by', auth()->id())
                ->paginate(5);

            return view('user.shorten', compact('urls'));
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'original_url' => 'required|url'
        ];
        $messages = [
            'original_url.required' => 'กรุณากรอก URL',
            'original_url.url' => 'กรุณากรอก URL ให้ถูกต้อง เช่น https://example.com'
        ];
        $request->validate($rules, $messages);

        $code = Str::random(6);

        $shortUrl = ShortUrl::create([
            'original_url' => $request->original_url,
            'short_code' => $code
        ]);

        return redirect()->route('shorten.index')->with('success', 'Shortened URL: '.url($code));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'original_url' => 'required|url',
        ], [
            'original_url.required' => 'กรุณากรอก URL',
            'original_url.url' => 'กรุณากรอก URL ให้ถูกต้อง เช่น https://example.com'
        ]);

        $url = ShortUrl::findOrFail($id);
        $url->original_url = $request->input('original_url');

        if ($request->has('regenerate_short_code')) {
            $code = Str::random(6);
            while (ShortUrl::where('short_code', $code)->exists()) {
                $code = Str::random(6);
            }
            $url->short_code = $code;
        }

        $url->save();

        return redirect()->back()->with('success', 'อัปเดตเรียบร้อยแล้ว');
    }

    public function destroy($id)
    {
        $url = ShortUrl::findOrFail($id);
        $url->delete();

        return redirect()->back()->with('success', 'ลบเรียบร้อยแล้ว');
    }

    public function redirect($code)
    {
        $short = ShortUrl::where('short_code', $code)->firstOrFail();
        return redirect($short->original_url);
    }
}
