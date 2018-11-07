<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181107180528 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE cart_line (id_product INT NOT NULL, id_client INT NOT NULL, tax INT NOT NULL, INDEX FK_cartLine_idProduct (id_product), INDEX FK_cartLine_idClient (id_client), PRIMARY KEY(id_product, id_client)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFDD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE cart_line ADD CONSTRAINT FK_3EF1B4CFE173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('DROP TABLE CartLine');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE CartLine (id_product INT NOT NULL, id_client INT NOT NULL, tax INT NOT NULL, INDEX FK_cartLine_idProduct (id_product), INDEX FK_cartLine_idClient (id_client), PRIMARY KEY(id_product, id_client)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE CartLine ADD CONSTRAINT FK_F52B7327DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE CartLine ADD CONSTRAINT FK_F52B7327E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('DROP TABLE cart_line');
    }
}
