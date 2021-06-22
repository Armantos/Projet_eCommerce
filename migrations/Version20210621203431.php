<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210621203431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, buyer_id INT NOT NULL, INDEX IDX_52EA1F096C755722 (buyer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item_article (order_item_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_DA7BC58E415FB15 (order_item_id), INDEX IDX_DA7BC587294869C (article_id), PRIMARY KEY(order_item_id, article_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F096C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE order_item_article ADD CONSTRAINT FK_DA7BC58E415FB15 FOREIGN KEY (order_item_id) REFERENCES order_item (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_item_article ADD CONSTRAINT FK_DA7BC587294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE order_article');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986C755722');
        $this->addSql('DROP INDEX IDX_F52993986C755722 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD user_id INT NOT NULL, ADD list_article LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', DROP buyer_id, DROP quantity');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F5299398A76ED395 ON `order` (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE order_item_article DROP FOREIGN KEY FK_DA7BC58E415FB15');
        $this->addSql('CREATE TABLE order_article (order_id INT NOT NULL, article_id INT NOT NULL, INDEX IDX_F440A72D8D9F6D38 (order_id), INDEX IDX_F440A72D7294869C (article_id), PRIMARY KEY(order_id, article_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D7294869C FOREIGN KEY (article_id) REFERENCES article (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE order_article ADD CONSTRAINT FK_F440A72D8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_item_article');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398A76ED395');
        $this->addSql('DROP INDEX IDX_F5299398A76ED395 ON `order`');
        $this->addSql('ALTER TABLE `order` ADD quantity INT NOT NULL, DROP list_article, CHANGE user_id buyer_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986C755722 FOREIGN KEY (buyer_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_F52993986C755722 ON `order` (buyer_id)');
    }
}
