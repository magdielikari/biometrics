<?php

use yii\db\Migration;

class m170327_174352_m1 extends Migration
{
    public $time = 'sdfgsd';
    public $number = 32142;
    public $name = 'asdfrasdf';
    public $event = 'adsfa';
    public $file_id = 28;
    
    public init($ti, $nu, $na, $ev, $fi)
    {
        $this->time = $ti;
        $this->number = $nu;
        $this->name = $na;
        $this->event = $ev;
        $this->file_id = $fi;
    }
    public function up()
    {
        $this->insert('data',[
            'time' => $this->time;
            'number' => $this->number;
            'name' => $this->name;
            'event' => $this->event;
            'file_id' => $this->file_id;
        ]);
    }

    public function down()
    {
        echo "m170327_174352_m1 cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
