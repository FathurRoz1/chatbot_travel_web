-- Adminer 4.8.1 PostgreSQL 17.6 dump

DROP TABLE IF EXISTS "cache";
CREATE TABLE "public"."cache" (
    "key" character varying(255) NOT NULL,
    "value" text NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "cache_pkey" PRIMARY KEY ("key")
) WITH (oids = false);


DROP TABLE IF EXISTS "cache_locks";
CREATE TABLE "public"."cache_locks" (
    "key" character varying(255) NOT NULL,
    "owner" character varying(255) NOT NULL,
    "expiration" integer NOT NULL,
    CONSTRAINT "cache_locks_pkey" PRIMARY KEY ("key")
) WITH (oids = false);


DROP TABLE IF EXISTS "failed_jobs";
DROP SEQUENCE IF EXISTS failed_jobs_id_seq;
CREATE SEQUENCE failed_jobs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."failed_jobs" (
    "id" bigint DEFAULT nextval('failed_jobs_id_seq') NOT NULL,
    "uuid" character varying(255) NOT NULL,
    "connection" text NOT NULL,
    "queue" text NOT NULL,
    "payload" text NOT NULL,
    "exception" text NOT NULL,
    "failed_at" timestamp(0) DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "failed_jobs_pkey" PRIMARY KEY ("id"),
    CONSTRAINT "failed_jobs_uuid_unique" UNIQUE ("uuid")
) WITH (oids = false);


DROP TABLE IF EXISTS "h_chatlog";
DROP SEQUENCE IF EXISTS h_chatlog_chatlog_id_seq;
CREATE SEQUENCE h_chatlog_chatlog_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 CACHE 1;

CREATE TABLE "public"."h_chatlog" (
    "chatlog_id" integer DEFAULT nextval('h_chatlog_chatlog_id_seq') NOT NULL,
    "question" text NOT NULL,
    "answer" text NOT NULL,
    "api_key" character varying(25) NOT NULL,
    "status" smallint NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    CONSTRAINT "h_chatlog_pkey" PRIMARY KEY ("chatlog_id")
) WITH (oids = false);

COMMENT ON COLUMN "public"."h_chatlog"."status" IS '1: answered; 2:unanswered;';


DROP TABLE IF EXISTS "job_batches";
CREATE TABLE "public"."job_batches" (
    "id" character varying(255) NOT NULL,
    "name" character varying(255) NOT NULL,
    "total_jobs" integer NOT NULL,
    "pending_jobs" integer NOT NULL,
    "failed_jobs" integer NOT NULL,
    "failed_job_ids" text NOT NULL,
    "options" text,
    "cancelled_at" integer,
    "created_at" integer NOT NULL,
    "finished_at" integer,
    CONSTRAINT "job_batches_pkey" PRIMARY KEY ("id")
) WITH (oids = false);


DROP TABLE IF EXISTS "jobs";
DROP SEQUENCE IF EXISTS jobs_id_seq;
CREATE SEQUENCE jobs_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 CACHE 1;

CREATE TABLE "public"."jobs" (
    "id" bigint DEFAULT nextval('jobs_id_seq') NOT NULL,
    "queue" character varying(255) NOT NULL,
    "payload" text NOT NULL,
    "attempts" smallint NOT NULL,
    "reserved_at" integer,
    "available_at" integer NOT NULL,
    "created_at" integer NOT NULL,
    CONSTRAINT "jobs_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "jobs_queue_index" ON "public"."jobs" USING btree ("queue");


DROP TABLE IF EXISTS "m_dataset";
DROP SEQUENCE IF EXISTS m_dataset_dataset_id_seq;
CREATE SEQUENCE m_dataset_dataset_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 10 CACHE 1;

CREATE TABLE "public"."m_dataset" (
    "dataset_id" integer DEFAULT nextval('m_dataset_dataset_id_seq') NOT NULL,
    "name" character varying(100) NOT NULL,
    "file_path" text NOT NULL,
    "created_at" timestamp DEFAULT CURRENT_TIMESTAMP NOT NULL,
    "created_by" integer NOT NULL,
    "updated_at" timestamp,
    "updated_by" integer,
    "deleted_at" timestamp,
    CONSTRAINT "m_dataset_pkey" PRIMARY KEY ("dataset_id")
) WITH (oids = false);

INSERT INTO "m_dataset" ("dataset_id", "name", "file_path", "created_at", "created_by", "updated_at", "updated_by", "deleted_at") VALUES
(1,	'Dataset Destinasi Wisata Indonesia',	'/files/travel/destinasi_indonesia.csv',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(2,	'Dataset Hotel & Akomodasi',	'/files/travel/hotel_akomodasi.xlsx',	'2025-11-25 20:02:04.194426',	2,	'2025-11-25 20:02:04.194426',	1,	NULL),
(3,	'Dataset Harga Tiket Pesawat 2024',	'/files/travel/tiket_pesawat_2024.csv',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(4,	'Dataset Penyewaan Mobil',	'/files/travel/rental_mobil.csv',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(5,	'Dataset Rute Transportasi Umum',	'/files/travel/rute_transportasi.csv',	'2025-11-25 20:02:04.194426',	2,	'2025-11-25 20:02:04.194426',	2,	NULL),
(6,	'Dataset Review Tempat Wisata',	'/files/travel/review_wisata.json',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(7,	'Dataset Cuaca Destinasi Favorit',	'/files/travel/cuaca_destinasi.xlsx',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(8,	'Dataset Paket Tour & Travel',	'/files/travel/paket_tour.csv',	'2025-11-25 20:02:04.194426',	2,	'2025-11-25 20:02:04.194426',	3,	NULL),
(9,	'Dataset Restoran Populer',	'/files/travel/restoran_populer.csv',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL),
(10,	'Dataset Bandara Internasional',	'/files/travel/bandara_internasional.csv',	'2025-11-25 20:02:04.194426',	2,	NULL,	NULL,	NULL);

DROP TABLE IF EXISTS "migrations";
DROP SEQUENCE IF EXISTS migrations_id_seq;
CREATE SEQUENCE migrations_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 2147483647 START 3 CACHE 1;

CREATE TABLE "public"."migrations" (
    "id" integer DEFAULT nextval('migrations_id_seq') NOT NULL,
    "migration" character varying(255) NOT NULL,
    "batch" integer NOT NULL,
    CONSTRAINT "migrations_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "migrations" ("id", "migration", "batch") VALUES
(1,	'0001_01_01_000000_create_users_table',	1),
(2,	'0001_01_01_000001_create_cache_table',	1),
(3,	'0001_01_01_000002_create_jobs_table',	1);

DROP TABLE IF EXISTS "password_reset_tokens";
CREATE TABLE "public"."password_reset_tokens" (
    "email" character varying(255) NOT NULL,
    "token" character varying(255) NOT NULL,
    "created_at" timestamp(0),
    CONSTRAINT "password_reset_tokens_pkey" PRIMARY KEY ("email")
) WITH (oids = false);


DROP TABLE IF EXISTS "sessions";
CREATE TABLE "public"."sessions" (
    "id" character varying(255) NOT NULL,
    "user_id" bigint,
    "ip_address" character varying(45),
    "user_agent" text,
    "payload" text NOT NULL,
    "last_activity" integer NOT NULL,
    CONSTRAINT "sessions_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

CREATE INDEX "sessions_last_activity_index" ON "public"."sessions" USING btree ("last_activity");

CREATE INDEX "sessions_user_id_index" ON "public"."sessions" USING btree ("user_id");

INSERT INTO "sessions" ("id", "user_id", "ip_address", "user_agent", "payload", "last_activity") VALUES
('ziUq5VsurxfpQNz3mNk2dih5QiMzXRuiYOsg1k2w',	2,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0',	'YTo1OntzOjY6Il90b2tlbiI7czo0MDoiSE0ybDYxcG91eHZ3aU1aZmxJVlBlY0dNcVdvZmpNUDQ2SERVbVpWbSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cDovL2xvY2FsaG9zdC9jaGF0Ym90LXRyYXZlbC9wdWJsaWMvZGF0YXNldCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ4OiJodHRwOi8vbG9jYWxob3N0L2NoYXRib3QtdHJhdmVsL3B1YmxpYy9kYXNoYm9hcmQiO3M6NToicm91dGUiO3M6MTU6ImRhc2hib2FyZC5pbmRleCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjI7fQ==',	1764082901),
('fghgXJEtI0HvHtOLzYsQ1kPQQVr7dbouCDzGVp6G',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiS2E4d0M1WnhLNWNubWRYYTFza0pkZDBlRnk0dDl3cEFheWFrTUZ2diI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NjoiaHR0cDovL2xvY2FsaG9zdC9jaGF0Ym90LXRyYXZlbC9wdWJsaWMvZGF0YXNldCI7fXM6OToiX3ByZXZpb3VzIjthOjI6e3M6MzoidXJsIjtzOjQ2OiJodHRwOi8vbG9jYWxob3N0L2NoYXRib3QtdHJhdmVsL3B1YmxpYy9kYXRhc2V0IjtzOjU6InJvdXRlIjtzOjEzOiJkYXRhc2V0LmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1764077487),
('SLATSrr5ewKI6X5mmhO1NvFBPMVF5ohukqHMUTJ2',	NULL,	'127.0.0.1',	'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:145.0) Gecko/20100101 Firefox/145.0',	'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiSWRDMFdFUUQwOFRhUUFwa2JYSEhuYmlqTVROcDdDZk16MDNBRWF5YSI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czo0NDoiaHR0cDovL2xvY2FsaG9zdC9jaGF0Ym90LXRyYXZlbC9wdWJsaWMvdXNlcnMiO31zOjk6Il9wcmV2aW91cyI7YToyOntzOjM6InVybCI7czo0NDoiaHR0cDovL2xvY2FsaG9zdC9jaGF0Ym90LXRyYXZlbC9wdWJsaWMvdXNlcnMiO3M6NToicm91dGUiO3M6MTE6InVzZXJzLmluZGV4Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==',	1764082656);

DROP TABLE IF EXISTS "users";
DROP SEQUENCE IF EXISTS users_id_seq;
CREATE SEQUENCE users_id_seq INCREMENT 1 MINVALUE 1 MAXVALUE 9223372036854775807 START 2 CACHE 1;

CREATE TABLE "public"."users" (
    "id" bigint DEFAULT nextval('users_id_seq') NOT NULL,
    "name" character varying(255) NOT NULL,
    "email" character varying(255) NOT NULL,
    "email_verified_at" timestamp(0),
    "password" character varying(255) NOT NULL,
    "remember_token" character varying(100),
    "created_at" timestamp(0),
    "updated_at" timestamp(0),
    "deleted_at" timestamp,
    CONSTRAINT "users_email_unique" UNIQUE ("email"),
    CONSTRAINT "users_pkey" PRIMARY KEY ("id")
) WITH (oids = false);

INSERT INTO "users" ("id", "name", "email", "email_verified_at", "password", "remember_token", "created_at", "updated_at", "deleted_at") VALUES
(2,	'Admin',	'admin@mail.com',	NULL,	'$2y$12$HBMpf2pZECvs2Cue0ghDOOKvGVm1Md0ygGPMRXyeTgnl4mnw1kJ.W',	'cP23Lz8R6k4ANlFS39D7a8ljjoJxLVjNKtWsLbcsvA2WKAnrCtUHotqdkAop',	'2025-11-25 12:49:21',	'2025-11-25 12:49:21',	NULL);

-- 2025-11-26 06:20:02.167084+07
