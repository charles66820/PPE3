<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181031004553 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE comment (id_comment INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, id_product INT DEFAULT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, title VARCHAR(100) DEFAULT NULL, content VARCHAR(1000) DEFAULT NULL, INDEX FK_comment_idClient (id_client), INDEX FK_comment_idProduct (id_product), PRIMARY KEY(id_comment)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE address (id_address INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, way VARCHAR(100) NOT NULL, complement VARCHAR(100) DEFAULT NULL, zip_code VARCHAR(10) NOT NULL, city VARCHAR(50) NOT NULL, country VARCHAR(50) NOT NULL, INDEX FK_address_idClient (id_client), PRIMARY KEY(id_address)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product (id_product INT AUTO_INCREMENT NOT NULL, id_category INT DEFAULT NULL, product_title VARCHAR(100) NOT NULL, unit_price_HT DOUBLE PRECISION NOT NULL, reference VARCHAR(255) NOT NULL, quantity INT NOT NULL, description VARCHAR(1000) NOT NULL, INDEX FK_product_idCategory (id_category), PRIMARY KEY(id_product)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id_category INT AUTO_INCREMENT NOT NULL, title_category VARCHAR(100) NOT NULL, name_category TEXT NOT NULL, PRIMARY KEY(id_category)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command_content (id_command_content INT AUTO_INCREMENT NOT NULL, id_command INT DEFAULT NULL, id_product INT DEFAULT NULL, id_tax INT DEFAULT NULL, unit_price_HT NUMERIC(15, 2) NOT NULL, quantity INT NOT NULL, discount NUMERIC(15, 2) DEFAULT NULL, INDEX FK_commandContent_idCommand (id_command), INDEX FK_commandContent_idTax (id_tax), INDEX FK_commandContent_idProduct (id_product), PRIMARY KEY(id_command_content)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE product_picture (id_product_picture INT AUTO_INCREMENT NOT NULL, id_product INT DEFAULT NULL, picture_name VARCHAR(100) DEFAULT NULL, INDEX FK_productPicture_idProduct (id_product), UNIQUE INDEX FK_productPicture_picture (picture_name), PRIMARY KEY(id_product_picture)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tax (id_tax INT AUTO_INCREMENT NOT NULL, tax DOUBLE PRECISION NOT NULL, PRIMARY KEY(id_tax)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE opinion (id_opinion INT AUTO_INCREMENT NOT NULL, id_client INT DEFAULT NULL, id_product INT DEFAULT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, score INT DEFAULT NULL, INDEX FK_opinion_idClient (id_client), INDEX FK_opinion_idProduct (id_product), PRIMARY KEY(id_opinion)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE command (id_command INT AUTO_INCREMENT NOT NULL, id_address_delivery INT DEFAULT NULL, id_client INT DEFAULT NULL, date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, total_HT NUMERIC(15, 2) DEFAULT NULL, shipping NUMERIC(15, 2) DEFAULT NULL, tax_on_command NUMERIC(3, 2) DEFAULT NULL, INDEX FK_command_idClient (id_client), INDEX FK_command_idAddressDelivery (id_address_delivery), PRIMARY KEY(id_command)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id_client INT AUTO_INCREMENT NOT NULL, id_default_address INT DEFAULT NULL, login VARCHAR(20) NOT NULL, email VARCHAR(100) NOT NULL, password VARCHAR(50) NOT NULL, last_name VARCHAR(50) DEFAULT NULL, first_name VARCHAR(50) DEFAULT NULL, phone_number VARCHAR(13) DEFAULT NULL, avatar_url VARCHAR(2000) NOT NULL, creation_date DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, confirmed TINYINT(1) NOT NULL, token VARCHAR(40) DEFAULT NULL, INDEX FK_client_idDefaultAddress (id_default_address), PRIMARY KEY(id_client)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CE173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CDD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD5697F554 FOREIGN KEY (id_category) REFERENCES category (id_category)');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634A505743A4 FOREIGN KEY (id_command) REFERENCES command (id_command)');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634ADD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE command_content ADD CONSTRAINT FK_11AF634A1025522C FOREIGN KEY (id_tax) REFERENCES tax (id_tax)');
        $this->addSql('ALTER TABLE product_picture ADD CONSTRAINT FK_C7025439DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('ALTER TABLE opinion ADD CONSTRAINT FK_AB02B027DD7ADDD FOREIGN KEY (id_product) REFERENCES product (id_product)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD42A844740 FOREIGN KEY (id_address_delivery) REFERENCES address (id_address)');
        $this->addSql('ALTER TABLE command ADD CONSTRAINT FK_8ECAEAD4E173B1B8 FOREIGN KEY (id_client) REFERENCES client (id_client)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C74404551695FD4C FOREIGN KEY (id_default_address) REFERENCES address (id_address)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD42A844740');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C74404551695FD4C');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CDD7ADDD');
        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634ADD7ADDD');
        $this->addSql('ALTER TABLE product_picture DROP FOREIGN KEY FK_C7025439DD7ADDD');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027DD7ADDD');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD5697F554');
        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634A1025522C');
        $this->addSql('ALTER TABLE command_content DROP FOREIGN KEY FK_11AF634A505743A4');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CE173B1B8');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81E173B1B8');
        $this->addSql('ALTER TABLE opinion DROP FOREIGN KEY FK_AB02B027E173B1B8');
        $this->addSql('ALTER TABLE command DROP FOREIGN KEY FK_8ECAEAD4E173B1B8');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE product');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE command_content');
        $this->addSql('DROP TABLE product_picture');
        $this->addSql('DROP TABLE tax');
        $this->addSql('DROP TABLE opinion');
        $this->addSql('DROP TABLE command');
        $this->addSql('DROP TABLE client');
    }
}
