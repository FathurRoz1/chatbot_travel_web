SELECT setval('h_chatlog_chatlog_id_seq', COALESCE((SELECT MAX(chatlog_id) FROM h_chatlog), 1));
SELECT setval('m_dataset_dataset_id_seq', COALESCE((SELECT MAX(dataset_id) FROM m_dataset), 1));
SELECT setval('users_id_seq', COALESCE((SELECT MAX(id) FROM users), 1));
