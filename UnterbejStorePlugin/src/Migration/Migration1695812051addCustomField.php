<?php declare(strict_types=1);

namespace UnterbejStorePlugin\Migration;

use Doctrine\DBAL\Connection;
use Shopware\Core\Framework\Migration\MigrationStep;

class Migration1695812051addCustomField extends MigrationStep
{

        public function getCreationTimestamp(): int
        {
            return 1695812051; 
        }
    
        public function update(Connection $connection): void
        {
           
            $connection->executeUpdate('
            INSERT INTO custom_field_set (id, name, config, created_at)
            VALUES (9999, "your_custom_field_set", NULL, NOW())
        ');

        // Add custom field to the set
        $connection->executeUpdate('
            INSERT INTO custom_field (id, custom_field_set_id, name, type, config, created_at)
            VALUES (9999, (SELECT id FROM custom_field_set WHERE name = "your_custom_field_set"), "your_custom_field", "text", NULL, NOW())
        ');

        // Associate the field set with products
        $connection->executeUpdate('
            INSERT INTO custom_field_set_relation (id, custom_field_set_id, entity_name, created_at)
            VALUES (9999, (SELECT id FROM custom_field_set WHERE name = "your_custom_field_set"), "product", NOW())
        ');

        }
    
        public function updateDestructive(Connection $connection): void
        {
            // Implement your destructive migration here if necessary
        }
    }