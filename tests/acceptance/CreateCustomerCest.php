<?php

use yii\helpers\Url;

class CreateCustomerCest
{
    public function ensureThatCustomerIsCreated(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/customer/create'));
        $I->see('Create Customer', 'h1');

        $I->amGoingTo('try to create a customer');
        $I->fillField('input[name="Customer[name]"]', 'Malina Gomez');
        $I->fillField('input[name="Customer[email]"]', 'malina@gomez.com');
        $I->click('Save');
        $I->wait(2); // wait for button to be clicked

        $I->seeInCurrentUrl('customer/view');
    }
}
