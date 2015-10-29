<?php

class ExampleTest extends TestCase {

	/** @test */
	public function it_loads_the_login_page()
	{
		$this->visit('/')
			->click('Start here.')
            ->seePageIs('/login')
			->see('Username');
	}

}
