<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230611151723 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft ADD collection_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE nft ADD CONSTRAINT FK_D9C7463C514956FD FOREIGN KEY (collection_id) REFERENCES collection_nft (id)');
        $this->addSql('CREATE INDEX IDX_D9C7463C514956FD ON nft (collection_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE nft DROP FOREIGN KEY FK_D9C7463C514956FD');
        $this->addSql('DROP INDEX IDX_D9C7463C514956FD ON nft');
        $this->addSql('ALTER TABLE nft DROP collection_id');
    }
}
