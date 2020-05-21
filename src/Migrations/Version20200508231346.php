<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200508231346 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BC4FFF555');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id)');
        $this->addSql('ALTER TABLE garage DROP FOREIGN KEY FK_9F26610BDB77003');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610BDB77003 FOREIGN KEY (professional_id) REFERENCES professional (id)');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89D07ECCB6');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE advert DROP FOREIGN KEY FK_54F1F40BC4FFF555');
        $this->addSql('ALTER TABLE advert ADD CONSTRAINT FK_54F1F40BC4FFF555 FOREIGN KEY (garage_id) REFERENCES garage (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE garage DROP FOREIGN KEY FK_9F26610BDB77003');
        $this->addSql('ALTER TABLE garage ADD CONSTRAINT FK_9F26610BDB77003 FOREIGN KEY (professional_id) REFERENCES professional (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89D07ECCB6');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89D07ECCB6 FOREIGN KEY (advert_id) REFERENCES advert (id) ON UPDATE CASCADE ON DELETE CASCADE');
    }
}
