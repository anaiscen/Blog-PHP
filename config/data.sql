--
-- Create roles
--

INSERT INTO role (id, `name`) VALUES
(1, 'admin'),
(2, 'user');


--
-- Create admin user
--

INSERT INTO `user` (id, pseudo, `password`, createdAt, role_id, validated) VALUES
(1, 'admin', '$2y$10$Mnze1eK6gJToM4GgMpr09ucWit1HOwl8AxBCQkNsMJ8Zcx1kKZWa6', '2020-11-25 12:50:21', 1, 1);

