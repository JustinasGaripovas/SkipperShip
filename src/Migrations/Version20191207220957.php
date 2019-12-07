<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191207220957 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE warehouse_worker (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, INDEX IDX_7AE6601393686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE client (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, INDEX IDX_C744045593686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE admin (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, INDEX IDX_880E0D7693686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, encoded_password VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE courier (id INT AUTO_INCREMENT NOT NULL, base_user_id INT NOT NULL, INDEX IDX_CF134C7C93686AF1 (base_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE warehouse_worker ADD CONSTRAINT FK_7AE6601393686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C744045593686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE admin ADD CONSTRAINT FK_880E0D7693686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE courier ADD CONSTRAINT FK_CF134C7C93686AF1 FOREIGN KEY (base_user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE warehouse_worker DROP FOREIGN KEY FK_7AE6601393686AF1');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C744045593686AF1');
        $this->addSql('ALTER TABLE admin DROP FOREIGN KEY FK_880E0D7693686AF1');
        $this->addSql('ALTER TABLE courier DROP FOREIGN KEY FK_CF134C7C93686AF1');
        $this->addSql('DROP TABLE warehouse_worker');
        $this->addSql('DROP TABLE client');
        $this->addSql('DROP TABLE admin');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE courier');
    }
}
