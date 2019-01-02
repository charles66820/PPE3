<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190101213413 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD42A844740');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4E173B1B8');
        $this->addSql('ALTER TABLE command CHANGE total_HT total_HT NUMERIC(15, 2) NOT NULL, CHANGE shipping shipping NUMERIC(15, 2) NOT NULL, CHANGE tax_on_command tax_on_command NUMERIC(3, 2) NOT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD42A844740 FOREIGN KEY (id_address_delivery) REFERENCES address (id_address) ON DELETE SET NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD42A844740');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4E173B1B8');
        $this->addSql('ALTER TABLE command CHANGE total_HT total_HT NUMERIC(15, 2) DEFAULT NULL, CHANGE shipping shipping NUMERIC(15, 2) DEFAULT NULL, CHANGE tax_on_command tax_on_command NUMERIC(3, 2) DEFAULT NULL');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD42A844740 FOREIGN KEY (id_address_delivery) REFERENCES address (id_address)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
    }
}
