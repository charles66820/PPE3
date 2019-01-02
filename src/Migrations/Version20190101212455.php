<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190101212455 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_picture DROP FOREIGN KEY FK_C7025439DD7ADDD');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C7025439DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE product_picture DROP FOREIGN KEY FK_C7025439DD7ADDD');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C7025439DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
    }
}
