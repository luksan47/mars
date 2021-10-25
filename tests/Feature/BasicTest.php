<?php

namespace Tests\Feature;

use App\Models\User;
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

        // 200 routes
        '/',
        'setlocale/{locale}',
        'color/{mode}',
        'login',
        'logout',
        'register',
        'password/reset',
        'password/email',
        'password/reset/{token}',
        'register/guest',
        'secretariat/user/update_password',
        'secretariat/user/update',
    ];

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

        $user = User::factory()->create(['verified' => true]);
        // Authenticated and verified user is allowed to see the homepage.
        $response = $this->actingAs($user)->get('/home');
        $response->assertStatus(200);

        $this->assertAuthenticatedAs($user);
    }

    // TODO: there could be more tests
    public function testUnverifiedUser()
    {
        $user = User::factory()->create(['verified' => false]);

        $working_routes = ['verification'];
        $skipped_routes = [
            'privacy_policy', 'img/{filename}', 'test_mails/{mail}/{send?}',
            // TODO: test these routes separately
            'network/admin/checkout/transaction/delete/{transaction}',
            'economic_committee/transaction/delete/{transaction}',
            'communication_committee/epistola/edit/{epistola}',
            'communication_committee/epistola/restore/{epistola}',
            'communication_committee/epistola/mark_as_sent/{epistola}',
            'communication_committee/epistola/delete/{epistola}',
        ];
        //$forbidden_routes = array_merge($this->protected_localization_routes);
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            $response = $this->getResponse($user, $route);

            if (in_array($route->uri(), $working_routes)) {
                $response->assertStatus(200);
            } elseif (in_array($route->uri(), $skipped_routes)) {
                // Skipping these...
            } else {
                $this->assertTrue(in_array($response->status(), [302, 403]), "Got " . $response->status() . " for " . $route->uri());
            }
        }
    }

    public function testVerifiedUser()
    {
        $user = User::factory()->create(['verified' => true]);

        $skipped_routes = [
            'privacy_policy', 'img/{filename}', 'test_mails/{mail}/{send?}',
            // These cause some problem... TODO: figure them out
            'localizations',
            'localizations/add',
            'faults/add',
            'secretariat/users',
            'report_bug',
        ];

        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $route) {
            $response = $this->getResponse($user, $route);

            if (in_array($route->uri(), $this->unprotected_routes)) {
                $this->assertTrue(in_array($response->status(), [200, 302]), "Got " . $response->status() . " for " . $route->uri());
            } elseif (in_array($route->uri(), $skipped_routes)) {
                // Skipping these...
            } else {
                $this->assertTrue(in_array($response->status(), [400, 403, 404]), "Got " . $response->status() . " for " . $route->uri());
            }
        }
    }

    private function getResponse($user, $route)
    {
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
