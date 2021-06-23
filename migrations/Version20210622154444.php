<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210622154444 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE animal (id INT AUTO_INCREMENT NOT NULL, type_id INT NOT NULL, name VARCHAR(50) DEFAULT NULL, birth_date DATETIME NOT NULL, height DOUBLE PRECISION NOT NULL, weight DOUBLE PRECISION NOT NULL, price INT NOT NULL, breed VARCHAR(255) DEFAULT NULL, adopted TINYINT(1) NOT NULL, adopted_at DATETIME DEFAULT NULL, INDEX IDX_6AAB231FC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_accessory (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, quantity INT NOT NULL, price INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE animal_type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE donation (id INT AUTO_INCREMENT NOT NULL, donator_id INT DEFAULT NULL, amount DOUBLE PRECISION NOT NULL, INDEX IDX_31E581A0831BACAF (donator_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE post (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, published_at DATETIME NOT NULL, INDEX IDX_5A8A6C8DF675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user_animal_accessory (user_id INT NOT NULL, animal_accessory_id INT NOT NULL, INDEX IDX_24004AAEA76ED395 (user_id), INDEX IDX_24004AAE95F27D83 (animal_accessory_id), PRIMARY KEY(user_id, animal_accessory_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE animal ADD CONSTRAINT FK_6AAB231FC54C8C93 FOREIGN KEY (type_id) REFERENCES animal_type (id)');
        $this->addSql('ALTER TABLE donation ADD CONSTRAINT FK_31E581A0831BACAF FOREIGN KEY (donator_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE post ADD CONSTRAINT FK_5A8A6C8DF675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user_animal_accessory ADD CONSTRAINT FK_24004AAEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_animal_accessory ADD CONSTRAINT FK_24004AAE95F27D83 FOREIGN KEY (animal_accessory_id) REFERENCES animal_accessory (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user_animal_accessory DROP FOREIGN KEY FK_24004AAE95F27D83');
        $this->addSql('ALTER TABLE animal DROP FOREIGN KEY FK_6AAB231FC54C8C93');
        $this->addSql('DROP TABLE animal');
        $this->addSql('DROP TABLE animal_accessory');
        $this->addSql('DROP TABLE animal_type');
        $this->addSql('DROP TABLE donation');
        $this->addSql('DROP TABLE post');
        $this->addSql('DROP TABLE user_animal_accessory');
    }
}
