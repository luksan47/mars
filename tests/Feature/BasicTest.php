<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class BasicTest extends TestCase
{
    /** WARNING: You have to add explicitely here if you meant to define a route that any verified user can access */
    private $unprotected_routes = [
        // Redirect routes
        'api/user',
        'verification',
        'home',
        'user',
        'faults',
        'faults/table',
        'faults/update',
        'documents',
        // 200 routes
        '/',
        'setlocale/{locale}',
        'login',
        'logout',
        'register',
        'password/reset',
        'password/email',
        'password/reset/{token}',
        'register/guest',
        'userdata/update_password',
        'userdata/update_email',
        'userdata/update_phone',
        'documents/import/show',
        'documents/license/print',
        'documents/status-cert/request',
    ];

    private $protected_localization_routes = [
        'localizations/admin',
        'localizations/approve',
        'localizations/approve_all',
        'localizations/delete',
    ];


    // In debug mode, the URIs are printed and can be checked what causes the problem.
    // Use phpunit for debugging.
    protected function tearDown() :void
    {
        if (config('app.debug')) {
            echo "\n";
        }
    }

    /**
     * A basic test.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testBasicAuth()
    {
        // Unauthenticated user is not allowed to see the homepage, redirected to login.
        $response = $this->get('/home');
        $response->assertStatus(302);

        $user = factory(User::class)->create(['verified' => true]);
        // Authenticated and verified user is allowed to see the homepage.
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    // TODO: there could be more tests
    public function testUnverifiedUser()
    {
        $user = factory(User::class)->create(['verified' => false]);

        $working_routes = ['verification'];
        $skipped_routes = ['privacy_policy', 'img/{filename}', 'test_mails/{mail}/{send?}'];
        //$forbidden_routes = array_merge($this->protected_localization_routes);
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            $response = $this->getResponse($user, $route);

            if (in_array($route->uri(), $working_routes)) {
                $response->assertStatus(200);
            } elseif (in_array($route->uri(), $skipped_routes)) {
                // Skipping these...
            }else {
                $this->assertTrue(in_array($response->status(), [302, 403]));
            }
        }
    }

    public function testVerifiedUser()
    {
        $user = factory(User::class)->create(['verified' => true]);

        $skipped_routes = ['privacy_policy', 'img/{filename}', 'test_mails/{mail}/{send?}',
            // These cause some problem... TODO: figure them out
            'localizations',
            'localizations/add',
            'faults/add',
            'secretariat/users',
            'documents/import/add',
            'documents/import/remove',
            'documents/import/download',
            'documents/import/print',
            'documents/license/download',
            'documents/status-cert/download',
        ];

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            $response = $this->getResponse($user, $route);

            if (in_array($route->uri(), $this->unprotected_routes)) {
                $this->assertTrue(in_array($response->status(), [200, 302]));
            } elseif (in_array($route->uri(), $skipped_routes)) {
                // Skipping these...
            } else {
                $response->assertStatus(403);
            }
        }
    }

    private function getResponse($user, $route)
    {
        if(config('app.debug')) {
            echo " " . $route->uri();
        }
        if ($route->methods[0] == 'GET') {
            $response = $this->actingAs($user)->get($route->uri());
        } elseif ($route->methods[0] == 'POST') {
            $response = $this->actingAs($user)->post($route->uri());
        } else {
            $response = $this->actingAs($user)->put($route->uri());
        }
        return $response;
    }
}
