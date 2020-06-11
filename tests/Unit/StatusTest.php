<?php

namespace Tests\Unit;

use App\Semester;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;

class StatusTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCurrentSemester()
    {
        $autumn_semester = factory(Semester::class)->make([
            'year' => 2020,
            'part' => 1,
        ]);
        $spring_semester = factory(Semester::class)->make([
            'year' => 2020,
            'part' => 2,
        ]);

        // Checking isAutumn and isSpring
        $this->assertFalse($spring_semester->isAutumn());
        $this->assertTrue($spring_semester->isSpring());
        $this->assertTrue($autumn_semester->isAutumn());
        $this->assertFalse($autumn_semester->isSpring());

        // Outside of current semester
        $fakeNow = Carbon::create(2020, 1, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertFalse($autumn_semester->equals(Semester::current()));
        $this->assertFalse($spring_semester->equals(Semester::current()));

        $fakeNow = Carbon::create(2021, 9, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertFalse($autumn_semester->equals(Semester::current()));
        $this->assertFalse($spring_semester->equals(Semester::current()));

        // Autumn semester
        $fakeNow = Carbon::create(2020, 9, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertTrue($autumn_semester->equals(Semester::current()));
        $this->assertFalse($spring_semester->equals(Semester::current()));

        $this->assertTrue(Semester::current()->isAutumn());
        $this->assertFalse(Semester::current()->isSpring());

        // Spring Semester
        $fakeNow = Carbon::create(2021, 2, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertFalse($autumn_semester->equals(Semester::current()));
        $this->assertTrue($spring_semester->equals(Semester::current()));

        $this->assertFalse(Semester::current()->isAutumn());
        $this->assertTrue(Semester::current()->isSpring());

        // Asserting edge cases
        $fakeNow = Carbon::create(2020, 8, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertTrue($autumn_semester->equals(Semester::current()));

        $fakeNow = Carbon::create(2021, 1, 31);
        Carbon::setTestNow($fakeNow);
        $this->assertTrue($autumn_semester->equals(Semester::current()));
        $this->assertFalse($spring_semester->equals(Semester::current()));

        $fakeNow = Carbon::create(2021, 7, 31);
        Carbon::setTestNow($fakeNow);
        $this->assertTrue($spring_semester->equals(Semester::current()));

        $fakeNow = Carbon::create(2021, 8, 1);
        Carbon::setTestNow($fakeNow);
        $this->assertFalse($spring_semester->equals(Semester::current()));
    }
}
