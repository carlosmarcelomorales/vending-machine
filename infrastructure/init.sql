CREATE TABLE IF NOT EXISTS `wallets` (
                                         `wallet_id` varchar(36) CHARACTER SET latin1 NOT NULL,
    `balance` decimal(10,2) NOT NULL,
    PRIMARY KEY (`wallet_id`)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8;

CREATE TABLE IF NOT EXISTS `items` (
                                       `item_id` int(11) unsigned NOT NULL AUTO_INCREMENT,
    `name` varchar(20) NOT NULL DEFAULT '',
    `price` decimal(10,2) NOT NULL,
    `stock` int(11) DEFAULT NULL,
    PRIMARY KEY (`item_id`)
    ) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

INSERT INTO `items` (`item_id`, `name`, `price`, `stock`)
VALUES
    (1, 'Water', 0.65, 10),
    (2, 'Juice', 1.00, 10),
    (3, 'Soda', 1.50, 10)
    ON DUPLICATE KEY UPDATE `name` = VALUES(`name`), `price` = VALUES(`price`), `stock` = VALUES(`stock`);
