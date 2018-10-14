<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20181014152029 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE taille (idtaille INT AUTO_INCREMENT NOT NULL, libelleTaille VARCHAR(100) NOT NULL, PRIMARY KEY(idtaille)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE adresse (IDAdresse INT AUTO_INCREMENT NOT NULL, Voie VARCHAR(100) NOT NULL, Complement VARCHAR(100) DEFAULT NULL, CodePostal VARCHAR(10) NOT NULL, Ville VARCHAR(50) NOT NULL, Pays VARCHAR(50) NOT NULL, IDClient INT DEFAULT NULL, INDEX FK_Adresse_IDClient (IDClient), PRIMARY KEY(IDAdresse)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contenucommande (idproduit INT DEFAULT NULL, IDContenuCommande INT AUTO_INCREMENT NOT NULL, PrixUnitaireHT NUMERIC(15, 3) NOT NULL, QuantiteContenu INT NOT NULL, Remise NUMERIC(15, 3) DEFAULT NULL, IDCommande INT DEFAULT NULL, IDTauxTaxe INT DEFAULT NULL, INDEX FK_ContenuCommande_IDCommande (IDCommande), INDEX IDTauxTaxe (IDTauxTaxe), INDEX idproduit (idproduit), PRIMARY KEY(IDContenuCommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commande (IDCommande INT AUTO_INCREMENT NOT NULL, DateCommande DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, TotalHT NUMERIC(15, 3) DEFAULT NULL, TotalTVA NUMERIC(15, 3) DEFAULT NULL, FraisPortHT NUMERIC(15, 3) DEFAULT NULL, IDAdresseFacturation INT DEFAULT NULL, IDAdresseLivraison INT DEFAULT NULL, IDClient INT DEFAULT NULL, INDEX FK_Commande_IDClient (IDClient), INDEX IDAdresseFacturation (IDAdresseFacturation), INDEX IDAdresseLivraison (IDAdresseLivraison), INDEX DateCommande (DateCommande), INDEX DateCommande_2 (DateCommande), PRIMARY KEY(IDCommande)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE avis (IDAvis INT AUTO_INCREMENT NOT NULL, DateAvis DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, Titre VARCHAR(100) DEFAULT NULL, Description VARCHAR(1000) DEFAULT NULL, Note INT DEFAULT NULL, IDClient INT DEFAULT NULL, IDProduit INT DEFAULT NULL, INDEX FK_Avis_IDClient (IDClient), INDEX FK_Avis_IDProduit (IDProduit), PRIMARY KEY(IDAvis)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE taxe (idTaxe INT AUTO_INCREMENT NOT NULL, tauxTaxe DOUBLE PRECISION NOT NULL, PRIMARY KEY(idTaxe)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE categorie (idcat INT DEFAULT NULL, IdCategorie INT AUTO_INCREMENT NOT NULL, LibelleCategorie VARCHAR(100) NOT NULL, nomsouscat TEXT NOT NULL, INDEX idcategorie (idcat), PRIMARY KEY(IdCategorie)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE photoproduit (IDPhotoProduit INT AUTO_INCREMENT NOT NULL, Photo VARCHAR(100) DEFAULT NULL, IDProduit INT DEFAULT NULL, INDEX FK_PhotoProduit_IDProduit (IDProduit), UNIQUE INDEX Photo (Photo), PRIMARY KEY(IDPhotoProduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE produits (idtaille INT DEFAULT NULL, IDProduit INT AUTO_INCREMENT NOT NULL, LibelleProduit VARCHAR(100) NOT NULL, PrixUnitaireHT DOUBLE PRECISION NOT NULL, Reference VARCHAR(255) NOT NULL, QuantiteProduit INT NOT NULL, DescriptionProduit VARCHAR(1000) NOT NULL, IdCategorie INT DEFAULT NULL, INDEX FK_Produits_IdCategorie (IdCategorie), INDEX idtaille (idtaille), PRIMARY KEY(IDProduit)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (iddefaultadresse INT DEFAULT NULL, IDClient INT AUTO_INCREMENT NOT NULL, Pseudo VARCHAR(20) NOT NULL, Email VARCHAR(100) NOT NULL, MotDePasse VARCHAR(50) NOT NULL, Nom VARCHAR(50) DEFAULT NULL, Prenom VARCHAR(50) DEFAULT NULL, Civilite VARCHAR(20) DEFAULT NULL, Telephone VARCHAR(13) DEFAULT NULL, AvatarUrl VARCHAR(25) NOT NULL, DateCreation DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, Actif TINYINT(1) NOT NULL, Token VARCHAR(40) NOT NULL, INDEX iddefaultadresse (iddefaultadresse), PRIMARY KEY(IDClient)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE adresse ADD CONSTRAINT FK_C35F0816929EF705 FOREIGN KEY (IDClient) REFERENCES client (IDClient)');
        $this->addSql('ALTER TABLE contenucommande ADD CONSTRAINT FK_D2D18AF0F0E50D55 FOREIGN KEY (IDCommande) REFERENCES commande (IDCommande)');
        $this->addSql('ALTER TABLE contenucommande ADD CONSTRAINT FK_D2D18AF0F6A1BE49 FOREIGN KEY (idproduit) REFERENCES produits (IDProduit)');
        $this->addSql('ALTER TABLE contenucommande ADD CONSTRAINT FK_D2D18AF0BBFFC4CD FOREIGN KEY (IDTauxTaxe) REFERENCES taxe (idTaxe)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67DC18D1E3A FOREIGN KEY (IDAdresseFacturation) REFERENCES adresse (IDAdresse)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D9A7C1D65 FOREIGN KEY (IDAdresseLivraison) REFERENCES adresse (IDAdresse)');
        $this->addSql('ALTER TABLE commande ADD CONSTRAINT FK_6EEAA67D929EF705 FOREIGN KEY (IDClient) REFERENCES client (IDClient)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0929EF705 FOREIGN KEY (IDClient) REFERENCES client (IDClient)');
        $this->addSql('ALTER TABLE avis ADD CONSTRAINT FK_8F91ABF0429B6720 FOREIGN KEY (IDProduit) REFERENCES produits (IDProduit)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634875B18CF FOREIGN KEY (idcat) REFERENCES categorie (IdCategorie)');
        $this->addSql('ALTER TABLE photoproduit ADD CONSTRAINT FK_85297C8C429B6720 FOREIGN KEY (IDProduit) REFERENCES produits (IDProduit)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C330B72B5 FOREIGN KEY (IdCategorie) REFERENCES categorie (IdCategorie)');
        $this->addSql('ALTER TABLE produits ADD CONSTRAINT FK_BE2DDF8C12ED2694 FOREIGN KEY (idtaille) REFERENCES taille (idtaille)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455CC45758D FOREIGN KEY (iddefaultadresse) REFERENCES adresse (IDAdresse)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C12ED2694');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67DC18D1E3A');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D9A7C1D65');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455CC45758D');
        $this->addSql('ALTER TABLE contenucommande DROP FOREIGN KEY FK_D2D18AF0F0E50D55');
        $this->addSql('ALTER TABLE contenucommande DROP FOREIGN KEY FK_D2D18AF0BBFFC4CD');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634875B18CF');
        $this->addSql('ALTER TABLE produits DROP FOREIGN KEY FK_BE2DDF8C330B72B5');
        $this->addSql('ALTER TABLE contenucommande DROP FOREIGN KEY FK_D2D18AF0F6A1BE49');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0429B6720');
        $this->addSql('ALTER TABLE photoproduit DROP FOREIGN KEY FK_85297C8C429B6720');
        $this->addSql('ALTER TABLE adresse DROP FOREIGN KEY FK_C35F0816929EF705');
        $this->addSql('ALTER TABLE commande DROP FOREIGN KEY FK_6EEAA67D929EF705');
        $this->addSql('ALTER TABLE avis DROP FOREIGN KEY FK_8F91ABF0929EF705');
        $this->addSql('DROP TABLE taille');
        $this->addSql('DROP TABLE adresse');
        $this->addSql('DROP TABLE contenucommande');
        $this->addSql('DROP TABLE commande');
        $this->addSql('DROP TABLE avis');
        $this->addSql('DROP TABLE taxe');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE photoproduit');
        $this->addSql('DROP TABLE produits');
        $this->addSql('DROP TABLE client');
    }
}
