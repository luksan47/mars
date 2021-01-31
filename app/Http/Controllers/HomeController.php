<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HomeController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home', ['information' => DB::table('home_page_news')->first()->text]);
    }

    public function colorMode($mode)
    {
        return response('ok')->cookie('theme', $mode, config('app.colormode_cookie_lifespan'));
    }

    public function welcome()
    {
        if (Auth::user()) {
            return redirect('home');
        }

        return view('welcome');
    }

    public function editNews(Request $request)
    {
        $user = Auth::user();
        if ($user->hasRoleBase(Role::STUDENT_COUNCIL)) {
            DB::table('home_page_news')->update([
                'text' => $request->text ?? "",
                'user_id' => $user->id
            ]);
            return redirect()->back()->with('message', __('general.successful_modification'));
        }
        abort(403);
    }

    public function verification()
    {
        return view('auth.verification');
    }

    public function privacyPolicy()
    {
        return Storage::response('public/adatvedelmi_tajekoztato.pdf');
    }

    public function setLocale($locale)
    {
        App::setLocale($locale);
        return redirect()->back()->cookie('locale', $locale, config('app.locale_cookie_lifespan'));
    }

    /**
     * E-mails need to access the logo.
     */
    public function getPicture($filename)
    {
        $path = public_path() . '//img//' . $filename;

        if (!File::exists($path)) {
            return response()->json(['message' => 'Image not found'], 404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /* Report bug */
    public function indexReportBug()
    {
        return view('report_bug');
    }

    public function reportBug(Request $request)
    {
        $username = Auth::user()->name;

        //personal auth token from your github.com account - see CONTRIBUTING.md
        $token = env('GITHUB_AUTH_TOKEN');

        $url = "https://api.github.com/repos/" . env('GITHUB_REPO') . "/issues";

        //request details, removing slashes and sanitize content
        $title = htmlspecialchars(stripslashes('Reported bug'), ENT_QUOTES);
        $body = htmlspecialchars(stripslashes($request->description), ENT_QUOTES);
        $body .= '\n\n> This bug is reported by ' . $username . ' and generated automatically.';

        //build json post
        $post = '{"title": "' . $title . '","body": "' . $body . '","labels": ["bug"] }';

        //set file_get_contents header info
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => [
                    'User-Agent: request',
                    'Content-type: application/x-www-form-urlencoded',
                    'Accept: application/vnd.github.v3+json',
                    'Authorization: token ' . $token,
                ],
                'content' => $post
            ]
        ];

        //initiate file_get_contents
        $context = stream_context_create($opts);

        //make request
        $content = file_get_contents($url, false, $context);

        //decode response to array
        $response_array = json_decode($content, true);

        return view('report_bug', ['url' => $response_array['html_url']]);
    }
}
