<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190101212728 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027DD7ADDD');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E173B1B8');
        $this->addSql('ALTER TABLE opinion CHANGE id_product id_product INT NOT NULL');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E173B1B8');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027DD7ADDD');
        $this->addSql('ALTER TABLE opinion CHANGE id_product id_product INT DEFAULT NULL');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
    }
}
