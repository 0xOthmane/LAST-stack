<?php

namespace App\Tests\Functional;

use App\Factory\PlanetFactory;
use App\Factory\VoyageFactory;
use App\Tests\AppPantherTestCase;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Panther\PantherTestCase;
use Zenstruck\Browser\Test\HasBrowser;
use Zenstruck\Foundry\Test\Factories;
use Zenstruck\Foundry\Test\ResetDatabase;

class VoyageControllerTest extends AppPantherTestCase
{
    use ResetDatabase;
    use Factories;
    // use HasBrowser;

    public function testCreateVoyage()
    {
        PlanetFactory::createOne([
            'name' => 'Earth',
        ]);
        VoyageFactory::createOne();

        // $this->browser()
        $this->pantherBrowser()
            ->visit('/')
            ->click('Voyages')
            ->waitForPageLoad()
            // ->ddScreenshot()
            // $browser->client()->waitFor('html[aria-busy="true"]');
            // $browser->client()->waitFor('html:not([aria-busy])');
            ->click('New Voyage')
            ->waitForDialog()
            ->fillField('Purpose', 'Test voyage')
            ->selectFieldOption('Planet', 'Earth')
            ->click('Save')
            ->waitForTurboFrameLoad()
            ->assertElementCount('table tbody tr', 2)
            ->assertNotSeeElement('dialog[open]')
            ->assertSee('Bon voyage');
    }
}
