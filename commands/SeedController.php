<?php

namespace app\commands;

use Yii;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * This command seeds the database
 */
class SeedController extends Controller
{
    /**
     * This command echoes what you have entered as the message.
     * @param string $message the message to be echoed.
     * @return int Exit code
     */
    public function actionIndex()
    {
        Yii::$app->db->createCommand()->batchInsert(
            'currencies',
            [ 
                'code',
                'value',
            ],
            [
               ['USD', 1.00],
               ['NPR', 118.45],        
            ])->execute();

        Yii::$app->db->createCommand()->batchInsert(
            'customers',
            [ 
                'name',
                'email',
            ],
            [
                ['Hari Bahadur', 'hari@bahadur.com'],
                ['Madan Bahadur', 'madan@bahadur.com'],        
            ])->execute();

        print 'Database seeded.' . PHP_EOL;
        return ExitCode::OK;
    }
}
