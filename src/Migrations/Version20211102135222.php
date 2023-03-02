<?php

declare(strict_types=1);

namespace Dotit\SyliusStorePlugin\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20211102135222 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE dotit_store (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, logo_name VARCHAR(255) NOT NULL, enabled TINYINT(1) NOT NULL, position INT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, UNIQUE INDEX UNIQ_B506F54F5E237E06 (name), UNIQUE INDEX UNIQ_B506F54F989D9B62 (slug), UNIQUE INDEX UNIQ_B506F54FE7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dotit_store_email (id INT AUTO_INCREMENT NOT NULL, store_id INT NOT NULL, value VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F58E945BF603EE73 (store_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dotit_store_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT NOT NULL, description LONGTEXT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_5F5AE1AB2C2AC5D3 (translatable_id), UNIQUE INDEX dotit_store_translation_uniq_trans (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE dotit_store_channels (channel_id INT NOT NULL, store_id INT NOT NULL, INDEX IDX_42A3C6D272F5A1AA (channel_id), INDEX IDX_42A3C6D2F603EE73 (store_id), PRIMARY KEY(channel_id, store_id)) DEFAULT CHARACTER SET UTF8 COLLATE `UTF8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE dotit_store_email ADD CONSTRAINT FK_F58E945BF603EE73 FOREIGN KEY (store_id) REFERENCES dotit_store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dotit_store_translation ADD CONSTRAINT FK_5F5AE1AB2C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES dotit_store (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE dotit_store_channels ADD CONSTRAINT FK_42A3C6D272F5A1AA FOREIGN KEY (channel_id) REFERENCES sylius_channel (id)');
        $this->addSql('ALTER TABLE dotit_store_channels ADD CONSTRAINT FK_42A3C6D2F603EE73 FOREIGN KEY (store_id) REFERENCES dotit_store (id)');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE dotit_store_email DROP FOREIGN KEY FK_F58E945BF603EE73');
        $this->addSql('ALTER TABLE dotit_store_translation DROP FOREIGN KEY FK_5F5AE1AB2C2AC5D3');
        $this->addSql('ALTER TABLE dotit_store_channels DROP FOREIGN KEY FK_42A3C6D2F603EE73');
        $this->addSql('DROP TABLE dotit_store');
        $this->addSql('DROP TABLE dotit_store_email');
        $this->addSql('DROP TABLE dotit_store_translation');
        $this->addSql('DROP TABLE dotit_store_channels');
    }
}
