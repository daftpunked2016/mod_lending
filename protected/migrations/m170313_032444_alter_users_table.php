<?php

class m170313_032444_alter_users_table extends CDbMigration
{
	public function up()
	{
		$transaction = $this->getDbConnection()->beginTransaction();

		try {
            $this->addColumn('user', 'dti_file_id', 'INT(11) AFTER business_name');
			$this->addColumn('user', 'sec_file_id', 'INT(11) AFTER dti_file_id');
            $transaction->commit();
        } catch(Exception $e) {
            echo "Exception: ".$e->getMessage()."\n";
            $transaction->rollback();
            return false;
        }
	}

	public function down()
	{
		$this->dropColumn('user', 'dti_file_id');
		$this->dropColumn('user', 'sec_file_id');
	}
}