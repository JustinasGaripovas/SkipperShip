<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191214154001 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE warehouse (id INT AUTO_INCREMENT NOT NULL, city_id INT NOT NULL, name VARCHAR(255) NOT NULL, post_code VARCHAR(10) NOT NULL, INDEX IDX_ECB38BFC8BAC62AF (city_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE city (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, crime_rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE warehouse_worker (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, warehouse_id INT NOT NULL, UNIQUE INDEX UNIQ_7AE6601393686AF1 (base_user_id), INDEX IDX_7AE660135080ECDE (warehouse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, UNIQUE INDEX UNIQ_C744045593686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE car (id INT AUTO_INCREMENT NOT NULL, weight_categoty VARCHAR(50) NOT NULL, plate_number VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE delivery (id INT AUTO_INCREMENT NOT NULL, client_id INT NOT NULL, courier_id INT DEFAULT NULL, warehouse_id INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, coordinates LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, weight DOUBLE PRECISION NOT NULL, recipient_information VARCHAR(255) NOT NULL, recipient_coordinates LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', INDEX IDX_3781EC1019EB6921 (client_id), INDEX IDX_3781EC10E3D8151C (courier_id), INDEX IDX_3781EC105080ECDE (warehouse_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, UNIQUE INDEX UNIQ_880E0D7693686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, encoded_password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, car_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_CF134C7C93686AF1 (base_user_id), UNIQUE INDEX UNIQ_CF134C7CC3C6F69F (car_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE warehouse ADD CONSTRAINT FK_ECB38BFC8BAC62AF FOREIGN KEY (city_id) REFERENCES city (id)');
        $this->addSql('ALTER TABLE warehouse_worker ADD CONSTRAINT FK_7AE6601393686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE warehouse_worker ADD CONSTRAINT FK_7AE660135080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045593686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC1019EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC10E3D8151C FOREIGN KEY (courier_id) REFERENCES courier (id)');
        $this->addSql('ALTER TABLE delivery ADD CONSTRAINT FK_3781EC105080ECDE FOREIGN KEY (warehouse_id) REFERENCES warehouse (id)');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7693686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier ADD CONSTRAINT FK_CF134C7C93686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier ADD CONSTRAINT FK_CF134C7CC3C6F69F FOREIGN KEY (car_id) REFERENCES car (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE warehouse_worker DROP FOREIGN KEY FK_7AE660135080ECDE');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC105080ECDE');
        $this->addSql('ALTER TABLE warehouse DROP FOREIGN KEY FK_ECB38BFC8BAC62AF');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC1019EB6921');
        $this->addSql('ALTER TABLE courier DROP FOREIGN KEY FK_CF134C7CC3C6F69F');
        $this->addSql('ALTER TABLE warehouse_worker DROP FOREIGN KEY FK_7AE6601393686AF1');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045593686AF1');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7693686AF1');
        $this->addSql('ALTER TABLE courier DROP FOREIGN KEY FK_CF134C7C93686AF1');
        $this->addSql('ALTER TABLE delivery DROP FOREIGN KEY FK_3781EC10E3D8151C');
        $this->addSql('DROP TABLE warehouse');
        $this->addSql('DROP TABLE city');
        $this->addSql('DROP TABLE warehouse_worker');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE car');
        $this->addSql('DROP TABLE delivery');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE courier');
    }
}
