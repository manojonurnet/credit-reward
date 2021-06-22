<?php

use yii\helpers\Url;

class CreateCurrencyCest
{
    public function ensureThatCurrencyIsCreated(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/currency/create'));
        $I->see('Create Currency', 'h1');

        $I->amGoingTo('try to create a currency');
        $I->fillField('input[name="Currency[code]"]', 'NPR');
        $I->fillField('input[name="Currency[value]"]', '118.00');
        $I->click('Save');
        $I->wait(2); // wait for button to be clicked

        $I->seeInCurrentUrl('currency/view');
    }
}
