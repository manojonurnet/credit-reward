<?php

namespace app\commands;

use yii\console\Controller;
use yii\console\ExitCode;
use app\models\Reward;
use app\models\Customer;

/**
 * This command calculates customer reward points
 */
class RewardController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        $customers = Customer::find()->all();
        
        foreach ($customers as $customer) {
            $rewards = 0;
            $claims = 0;

            // Collect all valid rewards
            foreach ($customer->rewards as $reward) {
                if ($reward->expiry_date <= date('Y-m-d')) {
                    $reward->status = 0;
                    $reward->save();
                } else {
                    $rewards += $reward->points;
                }
            }

            // Collect all claims
            foreach ($customer->claims as $claim) {
                $claims += $claim->points;
            }

            $customer->reward = $rewards - $claims;
            $customer->save();
        }

        print 'Rewards updated.' . PHP_EOL;
        return ExitCode::OK;
    }
}
