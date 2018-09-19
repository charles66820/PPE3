<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180919125316 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE lignepanier');
        $this->addSql('ALTER TABLE adresse CHANGE IDClient IDClient INT DEFAULT NULL');
        $this->addSql('ALTER TABLE contenucommande CHANGE idproduit idproduit INT DEFAULT NULL, CHANGE IDTauxTaxe IDTauxTaxe INT DEFAULT NULL, CHANGE IDCommande IDCommande INT DEFAULT NULL');
        $this->addSql('ALTER TABLE commande CHANGE IDAdresseFacturation IDAdresseFacturation INT DEFAULT NULL, CHANGE IDAdresseLivraison IDAdresseLivraison INT DEFAULT NULL');
        $this->addSql('ALTER TABLE produits CHANGE IdCategorie IdCategorie INT DEFAULT NULL');
        $this->addSql('ALTER TABLE souscategorie CHANGE idcat idcat INT DEFAULT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY fk_client_iddefaultadresse');
        $this->addSql('ALTER TABLE client CHANGE Actif Actif TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455CC45758D FOREIGN KEY (iddefaultadresse) REFERENCES adresse (IDAdresse)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE lignepanier (quantite INT DEFAULT NULL, IDProduit INT NOT NULL, IDClient INT NOT NULL, INDEX IDProduit (IDProduit), INDEX IDClient (IDClient), PRIMARY KEY(IDClient, IDProduit)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE lignepanier ADD CONSTRAINT FK_panier_IDCient FOREIGN KEY (IDClient) REFERENCES client (IDClient)');
        $this->addSql('ALTER TABLE lignepanier ADD CONSTRAINT FK_panier_IDProduit FOREIGN KEY (IDProduit) REFERENCES produits (IDProduit)');
        $this->addSql('ALTER TABLE adresse CHANGE IDClient IDClient INT NOT NULL');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455CC45758D');
        $this->addSql('ALTER TABLE client CHANGE Actif Actif TINYINT(1) DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT fk_client_iddefaultadresse FOREIGN KEY (iddefaultadresse) REFERENCES adresse (IDAdresse) ON UPDATE SET NULL ON DELETE SET NULL');
        $this->addSql('ALTER TABLE commande CHANGE IDAdresseFacturation IDAdresseFacturation INT NOT NULL, CHANGE IDAdresseLivraison IDAdresseLivraison INT NOT NULL');
        $this->addSql('ALTER TABLE contenucommande CHANGE idproduit idproduit INT NOT NULL, CHANGE IDCommande IDCommande INT NOT NULL, CHANGE IDTauxTaxe IDTauxTaxe INT NOT NULL');
        $this->addSql('ALTER TABLE produits CHANGE IdCategorie IdCategorie INT NOT NULL');
        $this->addSql('ALTER TABLE souscategorie CHANGE idcat idcat INT NOT NULL');
    }
}
