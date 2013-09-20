<?php

namespace Innova\PathBundle\Migrations\drizzle_pdo_mysql;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated migration based on mapping information: modify it with caution
 *
 * Generation date: 2013/09/19 04:13:56
 */
class Version20130919161356 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        $this->addSql("
            CREATE TABLE Step2ResourceNode (
                id INT AUTO_INCREMENT NOT NULL, 
                step_id INT DEFAULT NULL, 
                resourceNode_id INT DEFAULT NULL, 
                PRIMARY KEY(id), 
                INDEX IDX_C5D743873B21E9C (step_id), 
                INDEX IDX_C5D7438B87FAB32 (resourceNode_id)
            )
        ");
        $this->addSql("
            ALTER TABLE Step2ResourceNode 
            ADD CONSTRAINT FK_C5D743873B21E9C FOREIGN KEY (step_id) 
            REFERENCES innova_step (id)
        ");
        $this->addSql("
            ALTER TABLE Step2ResourceNode 
            ADD CONSTRAINT FK_C5D7438B87FAB32 FOREIGN KEY (resourceNode_id) 
            REFERENCES claro_resource_node (id)
        ");
    }

    public function down(Schema $schema)
    {
        $this->addSql("
            DROP TABLE Step2ResourceNode
        ");
    }
}