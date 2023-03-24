<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230324132758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8D9D86650F');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA50F1E14');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA50F1E14 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8D9D86650F ON post');
        $this->addSql('ALTER TABLE post ADD user_id INT DEFAULT NULL, ADD trip_id INT DEFAULT NULL, DROP user_id_id, DROP trip_id_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA5BC2E0E FOREIGN KEY (trip_id) REFERENCES trip (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA76ED395 ON post (user_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA5BC2E0E ON post (trip_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA76ED395');
        $this->addSql('ALTER TABLE post DROP FOREIGN KEY FK_5A8A6C8DA5BC2E0E');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA76ED395 ON post');
        $this->addSql('DROP INDEX IDX_5A8A6C8DA5BC2E0E ON post');
        $this->addSql('ALTER TABLE post ADD user_id_id INT DEFAULT NULL, ADD trip_id_id INT DEFAULT NULL, DROP user_id, DROP trip_id');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8D9D86650F FOREIGN KEY (user_id_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DA50F1E14 FOREIGN KEY (trip_id_id) REFERENCES trip (id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8DA50F1E14 ON post (trip_id_id)');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D9D86650F ON post (user_id_id)');
    }
}
