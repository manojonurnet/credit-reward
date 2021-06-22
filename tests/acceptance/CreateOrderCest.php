<?php

use yii\helpers\Url;

class CreateOrderCest
{
    public function ensureThatOrderIsCreated(AcceptanceTester $I)
    {
        $I->amOnPage(Url::toRoute('/order/create'));
        $I->see('Create Order', 'h1');

        $I->amGoingTo('try to create an order');
        $I->fillField('input[name="Order[detail]"]', 'iPhone 12 Pro');
        $I->selectOption('Customer ID','1');
        $I->fillField('input[name="Order[sale_amount]"]', '1100');
        $I->selectOption('Currency ID','1');
        $I->click('Save');
        $I->wait(2); // wait for button to be clicked

        $I->seeInCurrentUrl('order/view');
    }
}
