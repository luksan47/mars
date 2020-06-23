<?php

namespace Tests\Unit;

use App\Semester;
use Carbon\Carbon;
use Tests\TestCase;
//use Illuminate\Foundation\Testing\RefreshDatabase;

class SemesterTest extends TestCase
{
    // use RefreshDatabase;

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

        // Testing for far in the future (ie. the semester has to be created)
        $future_semester = factory(Semester::class)->make([
            'year' => 2032,
            'part' => 1,
        ]);
        $fakeNow = Carbon::create(2032, 11, 3);
        Carbon::setTestNow($fakeNow);
        $this->assertTrue($future_semester->equals(Semester::current()));
    }

    public function testPredSuc()
    {
        $autumn_semester = factory(Semester::class)->make([
            'year' => 2020,
            'part' => 1,
        ]);
        $spring_semester = factory(Semester::class)->make([
            'year' => 2020,
            'part' => 2,
        ]);

        $this->assertTrue($autumn_semester->succ()->equals($spring_semester));
        $this->assertTrue($spring_semester->pred()->equals($autumn_semester));
        $this->assertTrue($autumn_semester->succ()->pred()->equals($autumn_semester));
        $this->assertTrue($spring_semester->succ()->pred()->equals($spring_semester));

        $current_semester = Semester::current();
        $next_semester = Semester::next();
        $previous_semester = Semester::previous();

        $this->assertTrue($current_semester->succ()->equals($next_semester));
        $this->assertTrue($next_semester->pred()->equals($current_semester));

        $this->assertTrue($previous_semester->succ()->equals($current_semester));
        $this->assertTrue($current_semester->pred()->equals($previous_semester));

        $this->assertTrue($next_semester->pred()->pred()->equals($previous_semester));
        $this->assertTrue($previous_semester->next()->next()->equals($next_semester));
    }

    

}
