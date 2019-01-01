<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190101213534 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634A505743A4');
        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634ADD7ADDD');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634A505743A4 FOREIGN KEY (id_command) REFERENCES command (id_command) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634ADD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product) ON DELETE SET NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634A505743A4');
        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634ADD7ADDD');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634A505743A4 FOREIGN KEY (id_command) REFERENCES command (id_command)');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634ADD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
    }
}
