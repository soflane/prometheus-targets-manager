<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211106144425 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Created User, CustomField, CustomFieldValue & Target entities';
    }

    public function isTransactional(): bool {
      return FALSE;
    }

  public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE custom_field (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE custom_field_value (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', custom_field_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', target_id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', value VARCHAR(255) NOT NULL, INDEX IDX_EC7B05A1E5E0D4 (custom_field_id), INDEX IDX_EC7B05158E0B66 (target_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE target (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', url VARCHAR(255) NOT NULL, target_group VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id BINARY(16) NOT NULL COMMENT \'(DC2Type:ulid)\', username VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE custom_field_value ADD CONSTRAINT FK_EC7B05A1E5E0D4 FOREIGN KEY (custom_field_id) REFERENCES custom_field (id)');
        $this->addSql('ALTER TABLE custom_field_value ADD CONSTRAINT FK_EC7B05158E0B66 FOREIGN KEY (target_id) REFERENCES target (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE custom_field_value DROP FOREIGN KEY FK_EC7B05A1E5E0D4');
        $this->addSql('ALTER TABLE custom_field_value DROP FOREIGN KEY FK_EC7B05158E0B66');
        $this->addSql('DROP TABLE custom_field');
        $this->addSql('DROP TABLE custom_field_value');
        $this->addSql('DROP TABLE target');
        $this->addSql('DROP TABLE user');
    }
}
