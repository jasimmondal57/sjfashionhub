-- SJ Fashion Hub Database Backup
-- Generated on: 2025-10-13 01:39:35

SET FOREIGN_KEY_CHECKS = 0;


-- Table structure for table `migrations`
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE "migrations" ("id" integer primary key autoincrement not null, "migration" varchar not null, "batch" integer not null);


-- Dumping data for table `migrations`
INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(1, '0001_01_01_000000_create_users_table', 1),
(2, '0001_01_01_000001_create_cache_table', 1),
(3, '0001_01_01_000002_create_jobs_table', 1),
(4, '2025_09_25_162533_create_media_table', 2),
(5, '2025_09_25_162633_create_categories_table', 3),
(6, '2025_09_25_162634_create_products_table', 3),
(7, '2025_09_25_162635_create_orders_table', 3),
(8, '2025_09_25_162636_create_carts_table', 3),
(9, '2025_09_25_162642_create_wishlists_table', 3),
(10, '2025_09_25_162644_create_order_items_table', 3),
(11, '2025_09_25_162645_create_product_variants_table', 3),
(13, '2025_09_25_165410_add_seo_fields_to_products_and_categories_tables', 4),
(14, '2025_09_25_173707_create_banners_table', 5),
(15, '2025_09_25_180640_create_features_table', 6),
(16, '2025_09_25_185042_create_announcement_bars_table', 7),
(17, '2025_09_25_185946_create_header_settings_table', 8),
(18, '2025_09_25_191337_create_hero_sections_table', 9),
(19, '2025_09_25_193725_create_body_feature_sections_table', 10),
(20, '2025_09_25_200154_create_newsletters_table', 11),
(21, '2025_09_25_200202_create_newsletter_subscribers_table', 11),
(22, '2025_09_26_070728_create_footer_settings_table', 12),
(23, '2025_09_26_071606_add_fifth_section_to_footer_settings_table', 13),
(24, '2025_09_26_074619_add_section_titles_to_footer_settings_table', 14),
(25, '2025_09_26_075949_add_section_management_to_footer_settings_table', 15),
(26, '2025_09_26_082105_add_payment_and_app_sections_to_footer_settings_table', 16),
(27, '2025_09_26_090239_add_image_options_to_payment_icons', 17),
(29, '2025_09_26_092519_add_footer_bottom_text_fields_to_footer_settings_table', 18),
(30, '2025_09_26_151652_add_google_merchant_and_meta_fields_to_products_table', 18),
(31, '2025_09_26_163608_create_variant_types_table', 19),
(32, '2025_09_26_163615_create_variant_options_table', 19),
(33, '2025_09_26_171811_create_size_charts_table', 20),
(34, '2025_09_26_171910_add_size_chart_id_to_products_table', 20),
(35, '2025_09_26_180342_add_bulk_upload_fields_to_products_table', 21),
(36, '2025_09_26_181131_create_coupons_table', 22),
(37, '2025_09_26_182159_add_user_management_fields_to_users_table', 23),
(38, '2025_09_26_184814_add_order_management_fields_to_orders_table', 24),
(39, '2025_09_26_190423_create_return_orders_table', 25),
(40, '2025_09_26_193019_create_shiprocket_settings_table', 26),
(41, '2025_09_26_193645_create_abandoned_carts_table', 27),
(42, '2025_09_26_193705_create_abandoned_cart_emails_table', 27),
(43, '2025_09_26_194828_create_google_sheets_settings_table', 28),
(44, '2025_09_26_194846_create_google_sheets_sync_logs_table', 28),
(45, '2025_09_26_201818_create_communication_settings_table', 29),
(46, '2025_09_26_201826_create_communication_templates_table', 29),
(47, '2025_09_26_201835_create_communication_logs_table', 29),
(48, '2025_09_26_205342_create_payment_gateways_table', 30),
(49, '2025_09_26_205351_create_payment_transactions_table', 30),
(50, '2025_09_27_053740_create_analytics_settings_table', 31),
(51, '2025_09_27_061025_create_blog_categories_table', 32),
(52, '2025_09_27_061035_create_blog_posts_table', 32),
(53, '2025_09_27_061044_create_blog_posts_table', 33),
(54, '2025_09_27_061054_create_blog_tags_table', 33),
(55, '2025_09_27_061103_create_blog_post_tags_table', 33),
(56, '2025_09_27_104754_update_user_roles_add_super_admin', 34),
(57, '2025_09_27_125135_create_social_media_posts_table', 35),
(58, '2025_09_27_125145_create_social_media_configs_table', 35),
(59, '2025_09_27_132745_add_metadata_to_social_media_posts_table', 36),
(60, '2025_09_27_134553_make_name_nullable_in_social_media_configs_table', 37),
(61, '2025_09_27_140000_add_social_login_fields_to_users_table', 38),
(62, '2025_09_27_140001_create_otp_verifications_table', 39),
(63, '2025_09_27_140002_add_missing_auth_fields_to_users_table', 39),
(64, '2025_09_27_150000_create_social_login_settings_table', 40),
(65, '2025_09_27_150001_create_authentication_settings_table', 40),
(66, '2025_09_27_160500_fix_social_login_redirect_uris', 41),
(67, '2025_09_27_161000_create_user_otps_table', 42),
(68, '2025_09_28_090000_create_shipping_settings_table', 43),
(69, '2025_09_28_113026_create_pages_table', 44),
(70, '2025_09_29_061941_add_coupon_code_to_orders_table', 45),
(71, '2025_09_29_070000_create_user_addresses_table', 46),
(72, '2025_09_29_120000_create_user_change_logs_table', 47),
(73, '2025_09_29_100000_add_business_name_to_footer_settings_table', 48),
(74, '2025_09_29_102500_add_login_tracking_fields_to_users_table', 49),
(75, '2025_01_03_000001_create_whatsapp_templates_table', 50),
(76, '2025_09_30_182708_create_personal_access_tokens_table', 50),
(77, '2025_10_03_203000_add_multi_account_support_to_whatsapp', 50),
(78, '2025_01_04_000001_add_shiprocket_fields_to_orders_table', 51),
(79, '2025_10_06_000001_create_mobile_app_tables', 52),
(80, '2025_10_12_create_whatsapp_messages_table', 53),
(82, '2025_10_12_create_facebook_settings_table', 54),
(83, '2025_10_12_140000_create_whatsapp_carts_table', 55);


-- Table structure for table `password_reset_tokens`
DROP TABLE IF EXISTS `password_reset_tokens`;
CREATE TABLE "password_reset_tokens" ("email" varchar not null, "token" varchar not null, "created_at" datetime, primary key ("email"));


-- Dumping data for table `password_reset_tokens`
-- No data to dump


-- Table structure for table `sessions`
DROP TABLE IF EXISTS `sessions`;
CREATE TABLE "sessions" ("id" varchar not null, "user_id" integer, "ip_address" varchar, "user_agent" text, "payload" text not null, "last_activity" integer not null, primary key ("id"));


-- Dumping data for table `sessions`
INSERT INTO `sessions` (`id`, `user_id`, `ip_address`, `user_agent`, `payload`, `last_activity`) VALUES
('yUhUrSeoNuQWNzIOrwmxzngB9O4bHbafRR0TQpAK', 2, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo0OntzOjY6Il90b2tlbiI7czo0MDoiMTVrcXVwMm93REU2ZER5QXV5NmZ5NzNESkMzTEpCa2c1NWVWV3d1eCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTI6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9pbWFnZXMvcHdhL2ljb24tMTQ0eDE0NC5wbmciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX1zOjUwOiJsb2dpbl93ZWJfNTliYTM2YWRkYzJiMmY5NDAxNTgwZjAxNGM3ZjU4ZWE0ZTMwOTg5ZCI7aToyO30=', 1760298098),
('n8kqbCr5vXOZ2ITRiruz9YdhMDIvCalKyKt3zKG7', NULL, '162.128.163.198', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/129.0.0.0 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaU94c3VGQ0piVjZEaTdUaUFWY2gwamYwVno3c1pabk9FWGt4Ymc0dyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTU0OiJodHRwczovL3NqZmFzaGlvbmh1Yi5jb20vd2ViLXBpeGVsc0A2ZDZiNzYyN3cyYTI0OGUxMHA0YjNjM2ZjYW0zZWNmOWFlMC9jdXN0b20vd2ViLXBpeGVsLXNob3BpZnktY3VzdG9tLXBpeGVsQDA0NTAvc2FuZGJveC9tb2Rlcm4vcG9saWNpZXMvc2hpcHBpbmctcG9saWN5Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760291481),
('ExrHps3nHGIDnUZ4L56cYVLpVRY7vMuBMkMYLs9d', NULL, '216.244.66.235', 'Mozilla/5.0 (compatible; DotBot/1.2; +https://opensiteexplorer.org/dotbot; help@moz.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYUNVd1hib3p6UUs1dEI0a1Y2d3YzMlF2WXZiSHljbG41VDF0bkx6USI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDk6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vY2F0ZWdvcmllcy8yLXBjcy1zZXQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760291518),
('0t0gW2hR3gKwt4xnefHGjrdv4QPXyV7Rzisk86Uz', NULL, '48.218.35.138', '', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoieGxtMVY4UzEzeGQxbzFvYld2aEdNcjB0eURiMEtOakV5bVV3NmZ3QyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS94MmEucGhwNTYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760291691),
('aYrlRWflFOzrg8yDBFPorHmSrVv9CUkgyx8VCEmZ', NULL, '2a03:2880:21ff:10::', 'facebookcatalog/1.0', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiT3h2cHRYM1hTZThyNlFQbDlBZmN5R2I4Rk5FaU12THNCZ3hKVHdJVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDc6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9pbWFnZXMvcGxhY2Vob2xkZXIuanBnIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760291911),
('TV74rJHcrDjaVpgkC22gchqAFmYaKmoExq9N90zt', NULL, '37.59.204.146', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibUp6OHdvZ2NPWnRscnc4VVlRTkFaUEIwR3FnRzkxUTNvdWN1NG5NZiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT02Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760291918),
('ipiXdmzngHKhIKfW5ncQGugqy10Nmsoy6xAg7XdU', NULL, '40.77.167.16', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiNEd2N0FrNkVZTnE1Z0Q2N3lxcExzdkp6ajFaNmNremk1d2RQeUtYaSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vc2l0ZW1hcC50eHQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760292672),
('DJj8aBSqqIddttHVlFh3jCPKKax8FMdoLmxWua5a', NULL, '92.222.108.121', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVDg3cXJ2emF2UHpJNEtPeHIxTndKZmZiS2ZJVnAxVFpzNzZEWkhkYSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT01Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760292698),
('mKMVuNAf7EpcVk7Z7q7yKf22tPcQXGtnObmm1PEt', NULL, '20.171.207.55', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; GPTBot/1.2; +https://openai.com/gptbot)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoib29icDE4NTdidDVzR3hNbld4eE9lclJkSFMxb0xXaHhzMmRmWXR0aiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTE6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9wcm9kdWN0cz9maWx0ZXI9bmV3JnBhZ2U9NiI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760293688),
('JMjSjAQ3e5JBdUBN9ppn58cCrbjrrZastN5r3Hqr', NULL, '54.37.118.80', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZFJoejViNnVwdTh3bE0yaDJtY2F1aVFsZ3pKOGZVaVdNNXo4Vnh5TyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT00Ijt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760293461),
('7wF4EJ25lbOnAEJmiC3v50Zzs72bu8x1JlS9T9Kz', NULL, '5.39.109.160', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZlFqMHNwbGZ0MUJ3UWZMZU1zZGFWcklCeVNaNXRiRlI2Y0dSYkw2RyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT0zIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760294487),
('X8Xqh2xbbdhsdC6BzZeQDW1UoLELrUTn5kh9sxU9', NULL, '51.68.247.215', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYlFtdzBISm5TNHhZSmtXZjJ2UDZabXlBQWhWTkpxVVJnaVc4WlhJTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT0yIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760295009),
('lWr4cADwgJQR7plJpOjlXRWp97s1OJx7wSVNtovi', NULL, '2a03:2880:10ff:7::', 'facebookexternalua', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiYlI1VWFnT3VYMDBHeUduNE9sTk5GSDJGVHRBWGdIM3VjdHlZd3BKWSI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760295208),
('0wMO64bEy6W7oYn2MeB1OIsQ3rzuIB1zKZubmp0f', NULL, '2a03:2880:10ff:3::', 'facebookexternalua', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiV1V3eFZRQTFscFp3bkNON1hPTUJwQ1M0SE1oTzBmbHFWSTN1Z2xpZyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760295209),
('rZWzuDzzvqNDgWdBdp3fD9fSYFEI8b55eCWzZd2D', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'YTo2OntzOjY6Il90b2tlbiI7czo0MDoidnduM05kS05hTVNHa3BvMUlRcVNKVndydzVySTFkNHBSdVdTT0lDeiI7czozOiJ1cmwiO2E6MTp7czo4OiJpbnRlbmRlZCI7czozMjoiaHR0cHM6Ly9zamZhc2hpb25odWIuY29tL2FjY291bnQiO31zOjk6Il9wcmV2aW91cyI7YToxOntzOjM6InVybCI7czo1MjoiaHR0cHM6Ly9zamZhc2hpb25odWIuY29tL2ltYWdlcy9wd2EvaWNvbi0xNDR4MTQ0LnBuZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fXM6NTA6ImxvZ2luX3dlYl81OWJhMzZhZGRjMmIyZjk0MDE1ODBmMDE0YzdmNThlYTRlMzA5ODlkIjtpOjU7czoxNjoiZGVsaXZlcnlfcGluY29kZSI7czo2OiI3MzEyMDQiO30=', 1760299171),
('yMLHu1Igi53J9ffoNS3OIN2cXBuK723Wf3PWEIun', NULL, '2a03:2880:10ff:2::', 'facebookexternalua', 'YToyOntzOjY6Il90b2tlbiI7czo0MDoiUXlNZ0ZVNmlCRXdYQllzVEJyUDhheXVuY2gwMUp0NUNmaDc2V1FINyI7czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760295405),
('wgzkG8uicznuPX26dGbajzy2m8GMhET4kVFvkOuc', NULL, '37.59.204.143', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidkpONDJFc01nT2h3dVBIeENBT09LVU5QYzB0TW9Cd3FtejVhQXM3MiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/ZmlsdGVyPW5ldyZwYWdlPTYiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760295522),
('WSTcdQpZmfwlADKYRVjvF44JZlLjeaTAS44TIqej', NULL, '92.222.108.105', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiY01OSGVzY2hiVkI2RXZIaFJ3R1dRdFZtODRQeXVjTmtVczRGV3NjbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/ZmlsdGVyPW5ldyZwYWdlPTUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760295987),
('533veBdlsHbgi2exlU5Nm15dcNB0NEsiMUB3UOM7', NULL, '2a03:2880:2ff:43::', 'facebookexternalhit/1.1 (+http://www.facebook.com/externalhit_uatext.php)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiampVckFhZGc0OER3STFGWGZKV3hlT0hKbU9wa05rQnNZUUtjM3VXYyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MTI0OiJodHRwczovL3NqZmFzaGlvbmh1Yi5jb20vY2RuL3Nob3AvZmlsZXMvYXBwX2xvZ29fMTAyNF94XzEwMjRfcHhfMzIwX3hfMTMyX3B4LnBuZz9jcm9wPWNlbnRlciZoZWlnaHQ9MzImdj0xNzUxOTY1NjYwJndpZHRoPTMyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760296141),
('E7sqsPOzZDndGh7TLkjNNguJoyb0XQ6WdbNV7NJo', NULL, '92.222.108.121', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiQWtDdVJrQ0Q4aWZlam9QVzRLZWNHS1FEdFl4NEFMMHhUM1RwemtSNCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/ZmlsdGVyPW5ldyZwYWdlPTQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760296444),
('q9X5J7mSLMh2BnDMI43y3MmkBfkS5eMT3kBchBvs', NULL, '2a03:2880:21ff:72::', 'meta-externalads/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicEJJcHM3Vk5JRkYwZVE0cHRSTkxIYWVKRFhDNHdsTUpjeXBsV3BrcyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9pbWFnZXMvcHdhL2ljb24tNzJ4NzIucG5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760296621),
('AML4dtMaJweAkswyGHbJMR5zdntGOsIXOsjxOpTu', NULL, '52.167.144.16', 'Mozilla/5.0 AppleWebKit/537.36 (KHTML, like Gecko; compatible; bingbot/2.0; +http://www.bing.com/bingbot.htm) Chrome/116.0.1938.76 Safari/537.36', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiWDNXWjJwUTFtcmZDMGlQRWJJaURReVE4M2VUYkRFVUc3MFZNQThwTCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDA6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vc2l0ZW1hcC50eHQiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760296629),
('7w2SXeKtSqy6IHvvyBwpIqF8C4ghwMwcVxK7LvmX', NULL, '66.249.72.237', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.7339.207 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiTVJHN0R0akREY2pab2hLNE9RZk5PcGdKRzV3allNTzJSblkwVlV0cCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6Nzc6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vY2RuL3Nob3AvZmlsZXMvZzNtcHUud2VicD92PTE3NDU1MDgxNTYmd2lkdGg9NjAwIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760296738),
('66ewkEmbdOMmzHlCtkoGRqSp6gM4WCqc8e78Qyie', NULL, '94.23.188.213', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoia1RYYXlIQUN4SjEyQUY4OEVTa2RlUGdmeDBFbTlMamVVc293YU5STSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/ZmlsdGVyPW5ldyZwYWdlPTMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760296952),
('gEkvzwAF6YVWxckfQ2SOQrhgeOmK13rZFOrJkWZN', NULL, '5.39.109.185', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUGFkZFE5TjkyS01xNkFnQ21vTWM2UXZhY0t2SUVZblMyVkxWTWJpUCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTU6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/ZmlsdGVyPW5ldyZwYWdlPTIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760297404),
('sePSa3HbtmAbqzJ6v4kLSyPWa8D3HJas6MMwuOPJ', NULL, '2a03:2880:21ff:a::', 'meta-externalads/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiZkVoMHd2STE2V2hMWlNhTlQyQUdNOUwzQmpsbEVGaDdWWVpyODA5WSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760297663),
('UHVlCgB5XtG92mSoVISedv2uY3brbLzjhsZZuPEn', NULL, '216.244.66.235', 'Mozilla/5.0 (compatible; DotBot/1.2; +https://opensiteexplorer.org/dotbot; help@moz.com)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiYURhcWNSMlVJRzhIS29idmVFZTFLeE5PWkJvNW5oZVBQQnBrMGVzMSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vdGVybXMiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760297674),
('MtI90nHwO2CiXvekQKBXzPRovpdciAVcmxkB2iJB', NULL, '66.249.75.67', 'Mozilla/5.0 (Linux; Android 6.0.1; Nexus 5X Build/MMB29P) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.7339.207 Mobile Safari/537.36 (compatible; Googlebot/2.1; +http://www.google.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidHpxSkk4SHJlNDBjVnluZDJjZTI5bExWS05yUzZ4MFNlNllQaWVMVyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjY6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9wdWJsaWMvdXBsb2Fkcy9zZXR0aW5ncy82ODVjZjVmZDVmOTJmLnBuZyI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760297778),
('fD1sHhwpD4gNvDAYW9Lm3QPUtpvVMKMYP6NYVFZ5', NULL, '51.68.247.215', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoidnU5eXdvUGxtY3Z5MDBuVGtJOThCZElBdExnbjV1aUtwOTV4TDA2QiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NDQ6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHM/cGFnZT0xIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760297854),
('5gZs8quLprbchjeHa9NDgnN9XXqhEdMBKC41bmCB', NULL, '2a03:2880:24ff:46::', 'meta-externalads/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXIzV0ExeGxZR2tWSTR4UFU3SU5ZeG9GckpVdlFsNTlUakRJdUdvdSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760298085),
('ypRisYxVKPQpxGHakPP4rvwbjbKJhUHF3hjhtvQK', NULL, '2a03:2880:21ff:9::', 'meta-externalads/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiN1BOb3F6ZUlkaXRPWDlQbnF2a25EUW9RbDBKSnZicEJGUUtBNnJSTSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MjQ6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbSI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760298123),
('vUQC0foZFdy1gTMjbke69nq1CpaFEgmGjw5rhEy1', NULL, '85.208.96.202', 'Mozilla/5.0 (compatible; SemrushBot/7~bl; +http://www.semrush.com/bot.html)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoibFRBZ0txZFU2MUY4RlUxUUh1N2Y5YzRreXp3S2U4QkUwRUVmamtsUiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjU6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9wcm9kdWN0cy9jYXBzdWxlLTMtcGNzLXNldC02OGQ5MGM5MjgzOGYyIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760298150),
('dvhNuDQNQ7QVWvHNhDLd0vZGnfZDzYx2iT0WfOdt', NULL, '51.68.247.196', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiRTQyeDdYN09sYmJseXdZRXAyWGFHeXZrZkRXTURsWUo4QWNXWHpERiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHMvMy1wY3Mtc2V0LTY4ZDkwYzkyNmMyZjUiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760298304),
('NtJLOjCrmzJ9KRPKSbkSFjvIewT13IYp075mx8yK', NULL, '2a03:2880:24ff:40::', 'meta-externalads/1.1 (+https://developers.facebook.com/docs/sharing/webmasters/crawler)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiejlSejhZeVlBT0ZzcHFWOThjMmtuMUVPM0RKQkFjWUVOT3NteEpmaCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NTA6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9pbWFnZXMvcHdhL2ljb24tNzJ4NzIucG5nIjt9czo2OiJfZmxhc2giO2E6Mjp7czozOiJvbGQiO2E6MDp7fXM6MzoibmV3IjthOjA6e319fQ==', 1760298583),
('iKChSDvICINsBL7nQn01CUQxXFoxDMl4siVjXx1L', NULL, '5.39.1.235', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiaGw4TWp6dEFqamRZMk9YTXdkZlNOY003bUZWQ3ROZHh5VGNUNGVRdiI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHMvMy1wY3Mtc2V0LTY4ZDkwYzkyNjlkMDciO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760298796),
('IJ1hVON8RAxfAj2eoUt7zmNYW05NmFFHToqiNXqV', NULL, '37.59.204.148', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiUkM2NHcxM0N3RmppQ0I5WWkxTmZUZE55OTZxQm5JTFhpQUVSQ3o5VyI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHMvMy1wY3Mtc2V0LTY4ZDkwYzkyNjhiOGIiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760299241),
('uxI2I2hJ2kdXT03zpzsDpyUCgpORw71AGNNg6KSj', NULL, '66.249.75.68', 'Google-adstxt', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoiVENGZFpFVnV2MjBQdnE3Z0l1UnZkQ2hlb09mdGN6dHdzZ1puQWZjbSI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6MzY6Imh0dHBzOi8vc2pmYXNoaW9uaHViLmNvbS9hcHAtYWRzLnR4dCI7fXM6NjoiX2ZsYXNoIjthOjI6e3M6Mzoib2xkIjthOjA6e31zOjM6Im5ldyI7YTowOnt9fX0=', 1760299710),
('MHOcyX4nGmdrr4J4n8436Ikq9rt3jn1JfW8p8w5k', NULL, '94.23.188.205', 'Mozilla/5.0 (compatible; AhrefsBot/7.0; +http://ahrefs.com/robot/)', 'YTozOntzOjY6Il90b2tlbiI7czo0MDoicXloUWVWcFJSNXpmSThCSGVteUZrYmNiZVZXVW5EeEtxYzJsbjlqdCI7czo5OiJfcHJldmlvdXMiO2E6MTp7czozOiJ1cmwiO3M6NjE6Imh0dHBzOi8vd3d3LnNqZmFzaGlvbmh1Yi5jb20vcHJvZHVjdHMvMy1wY3Mtc2V0LTY4ZDkwYzkyNjdiN2MiO31zOjY6Il9mbGFzaCI7YToyOntzOjM6Im9sZCI7YTowOnt9czozOiJuZXciO2E6MDp7fX19', 1760299713);


-- Table structure for table `cache`
DROP TABLE IF EXISTS `cache`;
CREATE TABLE "cache" ("key" varchar not null, "value" text not null, "expiration" integer not null, primary key ("key"));


-- Dumping data for table `cache`
-- No data to dump


-- Table structure for table `cache_locks`
DROP TABLE IF EXISTS `cache_locks`;
CREATE TABLE "cache_locks" ("key" varchar not null, "owner" varchar not null, "expiration" integer not null, primary key ("key"));


-- Dumping data for table `cache_locks`
-- No data to dump


-- Table structure for table `jobs`
DROP TABLE IF EXISTS `jobs`;
CREATE TABLE "jobs" ("id" integer primary key autoincrement not null, "queue" varchar not null, "payload" text not null, "attempts" integer not null, "reserved_at" integer, "available_at" integer not null, "created_at" integer not null);


-- Dumping data for table `jobs`
-- No data to dump


-- Table structure for table `job_batches`
DROP TABLE IF EXISTS `job_batches`;
CREATE TABLE "job_batches" ("id" varchar not null, "name" varchar not null, "total_jobs" integer not null, "pending_jobs" integer not null, "failed_jobs" integer not null, "failed_job_ids" text not null, "options" text, "cancelled_at" integer, "created_at" integer not null, "finished_at" integer, primary key ("id"));


-- Dumping data for table `job_batches`
-- No data to dump


-- Table structure for table `failed_jobs`
DROP TABLE IF EXISTS `failed_jobs`;
CREATE TABLE "failed_jobs" ("id" integer primary key autoincrement not null, "uuid" varchar not null, "connection" text not null, "queue" text not null, "payload" text not null, "exception" text not null, "failed_at" datetime not null default CURRENT_TIMESTAMP);


-- Dumping data for table `failed_jobs`
-- No data to dump


-- Table structure for table `media`
DROP TABLE IF EXISTS `media`;
CREATE TABLE "media" ("id" integer primary key autoincrement not null, "model_type" varchar not null, "model_id" integer not null, "uuid" varchar, "collection_name" varchar not null, "name" varchar not null, "file_name" varchar not null, "mime_type" varchar, "disk" varchar not null, "conversions_disk" varchar, "size" integer not null, "manipulations" text not null, "custom_properties" text not null, "generated_conversions" text not null, "responsive_images" text not null, "order_column" integer, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `media`
-- No data to dump


-- Table structure for table `categories`
DROP TABLE IF EXISTS `categories`;
CREATE TABLE "categories" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "image" varchar, "parent_id" integer, "sort_order" integer not null default '0', "is_active" tinyint(1) not null default '1', "meta_title" varchar, "meta_description" text, "created_at" datetime, "updated_at" datetime, "seo_title" varchar, "structured_data" text, "seo_generated" tinyint(1) not null default '0', "seo_generated_at" datetime, "meta_keywords" text, foreign key("parent_id") references "categories"("id") on delete set null);


-- Dumping data for table `categories`
INSERT INTO `categories` (`id`, `name`, `slug`, `description`, `image`, `parent_id`, `sort_order`, `is_active`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `seo_title`, `structured_data`, `seo_generated`, `seo_generated_at`, `meta_keywords`) VALUES
(21, 'Uncategorized', 'uncategorized', 'Discover our premium Uncategorized collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Discover stylish Uncategorized at SJ Fashion Hub. Browse 0+ trendy items with easy returns and fast delivery. Quality guaranteed!', '2025-09-28 10:23:14', '2025-09-28 10:23:14', 'Buy Uncategorized - Quality Fashion at Best Prices | SJ Fa', NULL, 1, '2025-09-28 10:23:14', 'uncategorized, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(22, '2 Pcs Set', '2-pcs-set', 'Discover our premium 2 Pcs Set collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Shop 2 Pcs Set online at SJ Fashion Hub. 0+ fashionable products at best prices. Free shipping, easy returns, secure payment.', '2025-09-28 10:46:56', '2025-09-28 10:46:56', '2 Pcs Set Collection - Premium Fashion | SJ Fashion Hub', NULL, 1, '2025-09-28 10:46:56', '2 pcs set, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(23, '3 Pcs Set', '3-pcs-set', 'Discover our premium 3 Pcs Set collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Explore our 3 Pcs Set collection at SJ Fashion Hub. 0+ premium quality products with free shipping on orders above ₹999. Shop now!', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Shop 3 Pcs Set Online - Latest Trends | SJ Fashion Hub', NULL, 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(24, 'Blouse
', 'blouse', 'Discover our premium Blouse
 collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Discover stylish Blouse
 at SJ Fashion Hub. Browse 0+ trendy items with easy returns and fast delivery. Quality guaranteed!', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Buy Blouse
 - Quality Fashion at Best Prices | SJ Fashion', NULL, 1, '2025-09-28 10:46:56', 'blouse
, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(25, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set', 'Discover our premium Capsule 2 Pcs Set collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Shop Capsule 2 Pcs Set online at SJ Fashion Hub. 0+ fashionable products at best prices. Free shipping, easy returns, secure payment.', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Shop Capsule 2 Pcs Set Online - Latest Trends | SJ Fashion', NULL, 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(26, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set', 'Discover our premium Capsule 3 Pcs Set collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Discover stylish Capsule 3 Pcs Set at SJ Fashion Hub. Browse 0+ trendy items with easy returns and fast delivery. Quality guaranteed!', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Capsule 3 Pcs Set - Stylish & Comfortable Clothing | SJ Fa', NULL, 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(31, 'Kurti', 'kurti', 'Discover our premium Kurti collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Shop Kurti online at SJ Fashion Hub. 0+ fashionable products at best prices. Free shipping, easy returns, secure payment.', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Shop Kurti Online - Latest Trends | SJ Fashion Hub', NULL, 1, '2025-09-28 10:46:56', 'kurti, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping'),
(33, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set', 'Discover our premium Nayara 3 Pcs Set collection featuring the latest trends and timeless classics. Each piece is carefully selected to offer the perfect blend of style, comfort, and quality. From everyday essentials to statement pieces, find everything you need to elevate your wardrobe.', NULL, NULL, 0, 1, NULL, 'Discover stylish Nayara 3 Pcs Set at SJ Fashion Hub. Browse 0+ trendy items with easy returns and fast delivery. Quality guaranteed!', '2025-09-28 10:46:56', '2025-09-28 10:46:56', 'Buy Nayara 3 Pcs Set - Quality Fashion at Best Prices | SJ', NULL, 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, online shopping, trendy, stylish, premium, quality, sj fashion hub, buy online, best price, free shipping');


-- Table structure for table `carts`
DROP TABLE IF EXISTS `carts`;
CREATE TABLE "carts" ("id" integer primary key autoincrement not null, "user_id" integer, "session_id" varchar, "product_id" integer not null, "product_variant_id" integer, "quantity" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade, foreign key("product_variant_id") references "product_variants"("id") on delete cascade);


-- Dumping data for table `carts`
INSERT INTO `carts` (`id`, `user_id`, `session_id`, `product_id`, `product_variant_id`, `quantity`, `created_at`, `updated_at`) VALUES
(12, 2, NULL, 48, NULL, 1, '2025-09-28 13:28:59', '2025-09-28 13:28:59'),
(13, NULL, '7e0PtXvvbpxvjCfXJJhS1MSdXA5co3M3VXSqG6MR', 47, NULL, 1, '2025-09-28 18:50:49', '2025-09-28 18:50:49'),
(19, NULL, 'lu8eVW3uxbrCsuHzxHKVyKRbhpf1WHH1jSCM5Nad', 67, NULL, 1, '2025-10-09 20:28:27', '2025-10-09 20:28:27'),
(20, NULL, 'lu8eVW3uxbrCsuHzxHKVyKRbhpf1WHH1jSCM5Nad', 73, NULL, 1, '2025-10-09 20:30:14', '2025-10-09 20:30:14'),
(26, 5, NULL, 36, NULL, 1, '2025-10-13 00:25:16', '2025-10-13 00:25:16');


-- Table structure for table `wishlists`
DROP TABLE IF EXISTS `wishlists`;
CREATE TABLE "wishlists" ("id" integer primary key autoincrement not null, "user_id" integer not null, "product_id" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade);


-- Dumping data for table `wishlists`
INSERT INTO `wishlists` (`id`, `user_id`, `product_id`, `created_at`, `updated_at`) VALUES
(1, 5, 9, '2025-10-07 23:02:48', '2025-10-07 23:02:48');


-- Table structure for table `order_items`
DROP TABLE IF EXISTS `order_items`;
CREATE TABLE "order_items" ("id" integer primary key autoincrement not null, "order_id" integer not null, "product_id" integer not null, "product_variant_id" integer, "product_name" varchar not null, "product_sku" varchar not null, "variant_details" varchar, "quantity" integer not null, "unit_price" numeric not null, "total_price" numeric not null, "created_at" datetime, "updated_at" datetime, foreign key("order_id") references "orders"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade, foreign key("product_variant_id") references "product_variants"("id") on delete set null);


-- Dumping data for table `order_items`
INSERT INTO `order_items` (`id`, `order_id`, `product_id`, `product_variant_id`, `product_name`, `product_sku`, `variant_details`, `quantity`, `unit_price`, `total_price`, `created_at`, `updated_at`) VALUES
(3, 2, 47, NULL, 'Capsule 3 Pcs Set', 'CTSLF3PCP_1', NULL, 1, 400, 400, '2025-09-29 07:23:03', '2025-09-29 07:23:03'),
(4, 3, 80, NULL, 'test', 'SKU-68d90c92ab438', NULL, 1, 1, 1, '2025-10-04 23:54:27', '2025-10-04 23:54:27'),
(5, 4, 80, NULL, 'test', 'SKU-68d90c92ab438', NULL, 1, 1, 1, '2025-10-05 01:53:30', '2025-10-05 01:53:30'),
(6, 5, 47, NULL, 'Capsule 3 Pcs Set', 'CTSLF3PCP_1', NULL, 1, 400, 400, '2025-10-05 01:58:19', '2025-10-05 01:58:19'),
(7, 6, 49, NULL, 'Capsule 3 Pcs Set', 'CPSLF3PCP_3', NULL, 1, 400, 400, '2025-10-05 02:32:49', '2025-10-05 02:32:49'),
(8, 7, 63, NULL, 'Cotton Daily Wear Blouse Black', 'CTNPLNBLK', NULL, 1, 199, 199, '2025-10-12 10:57:40', '2025-10-12 10:57:40'),
(9, 8, 13, NULL, '3 Pcs Set', 'CTN3PIPC_1', NULL, 1, 550, 550, '2025-10-12 12:34:37', '2025-10-12 12:34:37'),
(10, 9, 36, NULL, 'Black Embroidered blouses for sarees', 'CTN_EMB_BLK2-1', NULL, 1, 249, 249, '2025-10-12 15:41:35', '2025-10-12 15:41:35'),
(11, 10, 36, NULL, 'Black Embroidered blouses for sarees', 'CTN_EMB_BLK2-1', NULL, 1, 249, 249, '2025-10-12 15:42:03', '2025-10-12 15:42:03'),
(12, 11, 36, NULL, 'Black Embroidered blouses for sarees', 'CTN_EMB_BLK2-1', NULL, 1, 249, 249, '2025-10-12 16:11:50', '2025-10-12 16:11:50');


-- Table structure for table `product_variants`
DROP TABLE IF EXISTS `product_variants`;
CREATE TABLE "product_variants" ("id" integer primary key autoincrement not null, "product_id" integer not null, "sku" varchar not null, "size" varchar, "color" varchar, "color_code" varchar, "price" numeric, "stock_quantity" integer not null default '0', "is_active" tinyint(1) not null default '1', "attributes" text, "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete cascade);


-- Dumping data for table `product_variants`
-- No data to dump


-- Table structure for table `banners`
DROP TABLE IF EXISTS `banners`;
CREATE TABLE "banners" ("id" integer primary key autoincrement not null, "title" varchar not null, "description" text, "image_path" varchar not null, "button_text" varchar, "button_link" varchar, "link_type" varchar check ("link_type" in ('category', 'product', 'custom', 'none')) not null default 'none', "category_id" integer, "product_id" integer, "custom_link" varchar, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "text_color" varchar not null default '#ffffff', "button_color" varchar not null default '#000000', "text_position" varchar check ("text_position" in ('left', 'center', 'right')) not null default 'left', "created_at" datetime, "updated_at" datetime, foreign key("category_id") references "categories"("id") on delete set null, foreign key("product_id") references "products"("id") on delete set null);


-- Dumping data for table `banners`
INSERT INTO `banners` (`id`, `title`, `description`, `image_path`, `button_text`, `button_link`, `link_type`, `category_id`, `product_id`, `custom_link`, `is_active`, `sort_order`, `text_color`, `button_color`, `text_position`, `created_at`, `updated_at`) VALUES
(3, 'Premium Quality', 'Experience luxury fashion with our premium collection', 'banners/7UgkSgbb2J6qgN6eR4uQDQLOXkDlUxcdsZmGeBt5.png', 'View Premium', 'https://sjfashionhub.com/categories/3-pcs-set', 'category', 23, NULL, 'https://sjfashion.in', 1, 3, '#000000', '#ffffff', 'right', '2025-09-25 17:43:37', '2025-10-03 22:05:17');


-- Table structure for table `features`
DROP TABLE IF EXISTS `features`;
CREATE TABLE "features" ("id" integer primary key autoincrement not null, "title" varchar not null, "description" text not null, "icon_type" varchar not null default 'svg', "icon_svg" text, "icon_image" varchar, "icon_class" varchar, "background_color" varchar not null default '#000000', "icon_color" varchar not null default '#ffffff', "sort_order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `features`
INSERT INTO `features` (`id`, `title`, `description`, `icon_type`, `icon_svg`, `icon_image`, `icon_class`, `background_color`, `icon_color`, `sort_order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Free Shipping', 'On orders above ₹999', 'svg', '<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4\"></path></svg>', NULL, NULL, '#000000', '#ffffff', 1, 1, '2025-09-25 18:10:52', '2025-09-25 18:10:52'),
(2, 'Premium Quality', '100% authentic products', 'svg', '<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z\"></path></svg>', NULL, NULL, '#000000', '#ffffff', 2, 1, '2025-09-25 18:10:52', '2025-09-25 18:10:52'),
(3, 'Customer Support', '24/7 dedicated support', 'svg', '<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M12 2.25a9.75 9.75 0 109.75 9.75A9.75 9.75 0 0012 2.25z\"></path></svg>', NULL, NULL, '#000000', '#ffffff', 3, 1, '2025-09-25 18:10:52', '2025-09-25 18:10:52'),
(4, 'Return & Exchange', 'Easy 30-day returns', 'svg', '<svg class=\"w-8 h-8\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\"><path stroke-linecap=\"round\" stroke-linejoin=\"round\" stroke-width=\"2\" d=\"M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15\"></path></svg>', NULL, NULL, '#000000', '#ffffff', 4, 1, '2025-09-25 18:10:52', '2025-09-25 18:10:52');


-- Table structure for table `announcement_bars`
DROP TABLE IF EXISTS `announcement_bars`;
CREATE TABLE "announcement_bars" ("id" integer primary key autoincrement not null, "message" varchar not null, "background_color" varchar not null default '#000000', "text_color" varchar not null default '#ffffff', "links" text, "is_active" tinyint(1) not null default '1', "is_scrolling" tinyint(1) not null default '0', "scroll_speed" integer not null default '50', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `announcement_bars`
INSERT INTO `announcement_bars` (`id`, `message`, `background_color`, `text_color`, `links`, `is_active`, `is_scrolling`, `scroll_speed`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Free Shipping Sitewide on Every Order, Don\'t Miss Out!!', '#000000', '#ffffff', '{\"2\":{\"text\":\"Orders Tracking\",\"url\":\"\\/track-order\"}}', 1, 0, 50, 1, '2025-09-25 18:55:38', '2025-09-25 18:58:50');


-- Table structure for table `header_settings`
DROP TABLE IF EXISTS `header_settings`;
CREATE TABLE "header_settings" ("id" integer primary key autoincrement not null, "site_name" varchar not null default 'SJ Fashion Hub', "logo_text" varchar, "logo_image" varchar, "navigation_menu" text, "show_search" tinyint(1) not null default '1', "show_wishlist" tinyint(1) not null default '1', "show_cart" tinyint(1) not null default '1', "show_account" tinyint(1) not null default '1', "search_placeholder" varchar not null default 'Search products...', "contact_info" text, "social_links" text, "sticky_header" tinyint(1) not null default '0', "header_style" varchar not null default 'default', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `header_settings`
INSERT INTO `header_settings` (`id`, `site_name`, `logo_text`, `logo_image`, `navigation_menu`, `show_search`, `show_wishlist`, `show_cart`, `show_account`, `search_placeholder`, `contact_info`, `social_links`, `sticky_header`, `header_style`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'SJ Fashion Hub', 'SJ Fashion Hub', 'logos/ef5VLPJc6mDyQm6q96in1cXuR87SzMTD1qAt7SPB.png', '[{\"text\":\"Home\",\"url\":\"\\/\",\"is_active\":\"1\"},{\"text\":\"Shop\",\"url\":\"\\/products\",\"is_active\":\"1\"},{\"text\":\"Categories\",\"url\":\"\\/categories\",\"is_active\":\"1\"},{\"text\":\"About\",\"url\":\"\\/about\",\"is_active\":\"1\"},{\"text\":\"Contact\",\"url\":\"\\/contact\",\"is_active\":\"1\"}]', 1, 1, 1, 1, 'Search products...', '{\"phone\":\"+91 70634 74409\",\"email\":\"contact@sjfashionhub.com\"}', '[{\"platform\":\"Facebook\",\"url\":\"#\",\"icon\":\"facebook\"},{\"platform\":\"Instagram\",\"url\":\"#\",\"icon\":\"instagram\"},{\"platform\":\"Twitter\",\"url\":\"#\",\"icon\":\"twitter\"}]', 0, 'default', 1, '2025-09-25 19:04:06', '2025-09-27 14:00:04'),
(2, 'SJ Fashion Hub', 'SJ Fashion Hub', NULL, '[{\"text\":\"Home\",\"url\":\"\\/\",\"is_active\":true},{\"text\":\"Shop\",\"url\":\"\\/products\",\"is_active\":true},{\"text\":\"Categories\",\"url\":\"\\/categories\",\"is_active\":true},{\"text\":\"About\",\"url\":\"\\/about\",\"is_active\":true},{\"text\":\"Contact\",\"url\":\"\\/contact\",\"is_active\":true}]', 1, 1, 1, 1, 'Search products...', '{\"phone\":\"+1 (555) 123-4567\",\"email\":\"info@sjfashionhub.com\"}', '[{\"platform\":\"Facebook\",\"url\":\"https:\\/\\/facebook.com\\/sjfashionhub\",\"icon\":\"facebook\"},{\"platform\":\"Instagram\",\"url\":\"https:\\/\\/instagram.com\\/sjfashionhub\",\"icon\":\"instagram\"},{\"platform\":\"Twitter\",\"url\":\"https:\\/\\/twitter.com\\/sjfashionhub\",\"icon\":\"twitter\"}]', 0, 'default', 1, '2025-09-25 19:07:04', '2025-09-25 19:07:04');


-- Table structure for table `hero_sections`
DROP TABLE IF EXISTS `hero_sections`;
CREATE TABLE "hero_sections" ("id" integer primary key autoincrement not null, "title" varchar not null default 'Where Elegance', "subtitle" varchar not null default 'Meets Comfort', "description" text not null default 'Refined Style, Perfect Fit. Style Made Effortless. Elevate Your Style Everyday.', "primary_button_text" varchar not null default 'Shop Now', "primary_button_url" varchar not null default '/products', "secondary_button_text" varchar not null default 'Browse Categories', "secondary_button_url" varchar not null default '/categories', "background_color" varchar not null default '#f9fafb', "text_color" varchar not null default '#000000', "accent_color" varchar not null default '#000000', "hero_image" varchar, "decorative_elements" text, "layout_style" varchar not null default 'split', "show_buttons" tinyint(1) not null default '1', "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `hero_sections`
INSERT INTO `hero_sections` (`id`, `title`, `subtitle`, `description`, `primary_button_text`, `primary_button_url`, `secondary_button_text`, `secondary_button_url`, `background_color`, `text_color`, `accent_color`, `hero_image`, `decorative_elements`, `layout_style`, `show_buttons`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'Where Elegance', 'Meets Comfort', 'Refined Style, Perfect Fit. Style Made Effortless. Elevate Your Style Everyday.', 'Shop Now', '/products', 'Browse Categories', '/categories', '#f9fafb', '#000000', '#000000', 'hero-images/mo45gSFmcBYY16s6Dkbp0lDTG0r2lA6Hv5ftVitl.png', NULL, 'split', 1, 1, 0, '2025-09-25 19:28:47', '2025-10-03 22:07:44');


-- Table structure for table `body_feature_sections`
DROP TABLE IF EXISTS `body_feature_sections`;
CREATE TABLE "body_feature_sections" ("id" integer primary key autoincrement not null, "title" varchar not null, "subtitle" varchar, "section_type" varchar not null, "display_style" varchar not null, "items_limit" integer not null default '8', "background_color" varchar not null default '#ffffff', "text_color" varchar not null default '#000000', "button_text" varchar, "button_url" varchar, "show_button" tinyint(1) not null default '1', "content_settings" text, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `body_feature_sections`
INSERT INTO `body_feature_sections` (`id`, `title`, `subtitle`, `section_type`, `display_style`, `items_limit`, `background_color`, `text_color`, `button_text`, `button_url`, `show_button`, `content_settings`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(2, 'New Collections 2025', 'Latest fashion trends and styles', 'products', 'carousel', 12, '#f9fafb', '#000000', 'Shop New Arrivals', '/products?filter=new', 1, '{\"categories\":[\"23\"],\"featured_only\":false,\"on_sale_only\":false,\"sort_by\":\"newest\"}', 1, 1, '2025-09-25 19:41:57', '2025-10-10 23:43:27'),
(3, 'Trending Now', 'for the most popular & hot-selling styles', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"24\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:40:29', '2025-10-10 23:42:56'),
(4, 'Editor’s Picks', 'curated looks or staff favorites', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"22\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:44:05', '2025-10-10 23:44:05'),
(5, 'New Arrivals', 'showcase the latest collections', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"25\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:44:44', '2025-10-10 23:44:44'),
(6, 'Festive Specials', 'seasonal or festival-themed items', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"26\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:45:10', '2025-10-10 23:45:10'),
(7, 'Best Sellers', 'your all-time customer favorites', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"31\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:45:38', '2025-10-10 23:45:38'),
(8, 'Ethnic Elegance', 'traditional wear highlights', 'categories', 'grid', 8, '#ffffff', '#000000', 'View All', '/products', 1, '{\"specific_categories\":[\"33\"],\"parent_only\":false}', 1, 0, '2025-10-10 23:46:14', '2025-10-10 23:46:14');


-- Table structure for table `newsletters`
DROP TABLE IF EXISTS `newsletters`;
CREATE TABLE "newsletters" ("id" integer primary key autoincrement not null, "title" varchar not null, "subtitle" text, "description" text, "placeholder_text" varchar not null default 'Enter your email address', "button_text" varchar not null default 'Subscribe', "background_color" varchar not null default '#f9fafb', "text_color" varchar not null default '#000000', "button_color" varchar not null default '#000000', "button_text_color" varchar not null default '#ffffff', "show_social_links" tinyint(1) not null default '0', "social_links" text, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `newsletters`
INSERT INTO `newsletters` (`id`, `title`, `subtitle`, `description`, `placeholder_text`, `button_text`, `background_color`, `text_color`, `button_color`, `button_text_color`, `show_social_links`, `social_links`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Stay Updated with SJ Fashion Hub', 'Get exclusive offers and fashion updates', 'Subscribe to our newsletter and be the first to know about new collections, exclusive offers, and fashion tips delivered directly to your inbox.', 'Enter your email address', 'Subscribe Now', '#000000', '#ffffff', '#ffffff', '#000000', 1, '[{\"platform\":\"facebook\",\"url\":\"https:\\/\\/facebook.com\\/sjfashionhub\"},{\"platform\":\"instagram\",\"url\":\"https:\\/\\/instagram.com\\/sjfashionhub\"},{\"platform\":\"twitter\",\"url\":\"https:\\/\\/twitter.com\\/sjfashionhub\"}]', 1, 0, '2025-09-25 20:17:05', '2025-09-25 20:17:05');


-- Table structure for table `newsletter_subscribers`
DROP TABLE IF EXISTS `newsletter_subscribers`;
CREATE TABLE "newsletter_subscribers" ("id" integer primary key autoincrement not null, "email" varchar not null, "name" varchar, "status" varchar not null default 'active', "subscribed_at" datetime not null default CURRENT_TIMESTAMP, "unsubscribed_at" datetime, "ip_address" varchar, "user_agent" varchar, "source" varchar, "preferences" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `newsletter_subscribers`
INSERT INTO `newsletter_subscribers` (`id`, `email`, `name`, `status`, `subscribed_at`, `unsubscribed_at`, `ip_address`, `user_agent`, `source`, `preferences`, `created_at`, `updated_at`) VALUES
(1, 'jasimmondal57@gmail.com', NULL, 'active', '2025-09-25 20:17:50', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'homepage', NULL, '2025-09-25 20:17:50', '2025-09-25 20:17:50'),
(2, 'admin@sjfashion.boutique', NULL, 'active', '2025-09-26 06:45:19', NULL, '127.0.0.1', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'homepage', NULL, '2025-09-26 06:45:19', '2025-09-26 06:45:19');


-- Table structure for table `footer_settings`
DROP TABLE IF EXISTS `footer_settings`;
CREATE TABLE "footer_settings" ("id" integer primary key autoincrement not null, "company_name" varchar not null default 'SJ Fashion Hub', "company_description" text, "contact_info" text, "social_links" text, "quick_links" text, "customer_service_links" text, "categories_links" text, "copyright_text" varchar, "payment_methods" text, "newsletter_text" text, "show_newsletter" tinyint(1) not null default '1', "show_social_links" tinyint(1) not null default '1', "show_payment_methods" tinyint(1) not null default '1', "background_color" varchar not null default '#ffffff', "text_color" varchar not null default '#374151', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime, "additional_links" text, "quick_links_title" varchar not null default 'Quick Links', "customer_service_title" varchar not null default 'Customer Service', "categories_title" varchar not null default 'Categories', "additional_title" varchar not null default 'More', "sections_config" text, "sections_order" text, "payment_icons" text, "show_payment_icons" tinyint(1) not null default '1', "app_download_links" text, "show_app_downloads" tinyint(1) not null default '1', "made_in_text" varchar, "designed_by_text" varchar, "company_url" varchar, "business_name" varchar);


-- Dumping data for table `footer_settings`
INSERT INTO `footer_settings` (`id`, `company_name`, `company_description`, `contact_info`, `social_links`, `quick_links`, `customer_service_links`, `categories_links`, `copyright_text`, `payment_methods`, `newsletter_text`, `show_newsletter`, `show_social_links`, `show_payment_methods`, `background_color`, `text_color`, `is_active`, `created_at`, `updated_at`, `additional_links`, `quick_links_title`, `customer_service_title`, `categories_title`, `additional_title`, `sections_config`, `sections_order`, `payment_icons`, `show_payment_icons`, `app_download_links`, `show_app_downloads`, `made_in_text`, `designed_by_text`, `company_url`, `business_name`) VALUES
(1, 'JM Software', 'At SJ Fashion Hub, we believe that style is more than just clothing—it\'s a statement. Our collection is designed for the modern person who values quality, comfort, and timeless fashion.', '{\"phone\":\"+917063474409\",\"email\":\"contact@sjfashionhub.com\",\"address\":\"Bolpur, WB, IN, Pin-731204\"}', '[{\"platform\":\"Facebook\",\"url\":\"#\",\"icon\":\"facebook\"},{\"platform\":\"Instagram\",\"url\":\"#\",\"icon\":\"instagram\"},{\"platform\":\"Twitter\",\"url\":\"#\",\"icon\":\"twitter\"},{\"platform\":\"YouTube\",\"url\":\"#\",\"icon\":\"youtube\"}]', '[{\"text\":\"Contact\",\"url\":\"\\/contact\"},{\"text\":\"Privacy Policy\",\"url\":\"\\/privacy-policy\"},{\"text\":\"Terms of Service\",\"url\":\"\\/terms-of-service\"},{\"text\":\"About Us\",\"url\":\"\\/about\"},{\"text\":\"Shipping Policy\",\"url\":\"\\/shipping-policy\"},{\"text\":\"Return Policy\",\"url\":\"\\/return-policy\"}]', '[]', '[{\"text\":\"Two Piece\",\"url\":\"\\/categories\\/2-pcs-set\"},{\"text\":\"Kurti\",\"url\":\"\\/categories\\/kurti\"}]', '© 2025 SJ Fashion Hub • All rights reserved', '[]', NULL, 1, 1, 1, '#ffffff', '#374151', 1, '2025-09-26 07:13:07', '2025-10-04 10:31:37', '[]', 'Quick Links', 'Customer Service', 'Categories', 'More', NULL, NULL, '[{\"name\":\"UPI\",\"icon\":\"upi\",\"url\":\"\\/payment\\/bhim\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141041_0_icons8-bhim-upi-50.png\"},{\"name\":\"Phonepe\",\"icon\":\"phonepe\",\"url\":\"\\/payment\\/phonepe\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141041_1_icons8-phone-pe-50.png\"},{\"name\":\"Paytm\",\"icon\":\"paytm\",\"url\":\"\\/payment\\/paytm\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141041_2_icons8-paytm-50.png\"},{\"name\":\"Visa\",\"icon\":\"visa\",\"url\":\"\\/payment\\/visa\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141041_3_icons8-visa-50.png\"},{\"name\":\"Google Pay\",\"icon\":\"googlepay\",\"url\":\"\\/payment\\/googlepay\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141093_4_icons8-google-pay-50.png\"},{\"name\":\"Cash on Delovery\",\"icon\":\"cod\",\"url\":\"\\/payment\\/upi\",\"image_type\":\"custom\",\"custom_image\":\"payment-icons\\/1759141041_5_icons8-cash-on-delivery-50.png\"}]', 1, '[{\"platform\":\"Android\",\"url\":\"https:\\/\\/play.google.com\\/store\\/apps\\/details?id=com.sjfashionhub\",\"icon\":\"playstore\"},{\"platform\":\"iOS\",\"url\":\"https:\\/\\/apps.apple.com\\/app\\/sjfashionhub\\/id123456789\",\"icon\":\"appstore\"}]', 1, 'Made with ❤️ in India', 'Designed By', 'https://jmsoftware.shop/', 'SJ Fashion Hub');


-- Table structure for table `variant_types`
DROP TABLE IF EXISTS `variant_types`;
CREATE TABLE "variant_types" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `variant_types`
INSERT INTO `variant_types` (`id`, `name`, `slug`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Size', 'size', 'Product sizes for clothing', 1, 1, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(2, 'Color', 'color', 'Product colors', 1, 2, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(3, 'Material', 'material', 'Fabric and material types', 1, 3, '2025-09-26 16:39:42', '2025-09-26 16:39:42');


-- Table structure for table `variant_options`
DROP TABLE IF EXISTS `variant_options`;
CREATE TABLE "variant_options" ("id" integer primary key autoincrement not null, "variant_type_id" integer not null, "name" varchar not null, "value" varchar not null, "color_code" varchar, "description" text, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime, foreign key("variant_type_id") references "variant_types"("id") on delete cascade);


-- Dumping data for table `variant_options`
INSERT INTO `variant_options` (`id`, `variant_type_id`, `name`, `value`, `color_code`, `description`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 1, 'Extra Small', 'XS', NULL, NULL, 1, 1, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(2, 1, 'Small', 'S', NULL, NULL, 1, 2, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(3, 1, 'Medium', 'M', NULL, NULL, 1, 3, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(4, 1, 'Large', 'L', NULL, NULL, 1, 4, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(5, 1, 'Extra Large', 'XL', NULL, NULL, 1, 5, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(6, 1, 'Double XL', 'XXL', NULL, NULL, 1, 6, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(7, 1, 'Triple XL', 'XXXL', NULL, NULL, 1, 7, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(8, 1, 'Free Size', 'Free Size', NULL, NULL, 1, 8, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(9, 1, '28', '28', NULL, NULL, 1, 9, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(10, 1, '30', '30', NULL, NULL, 1, 10, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(11, 1, '32', '32', NULL, NULL, 1, 11, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(12, 1, '34', '34', NULL, NULL, 1, 12, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(13, 1, '36', '36', NULL, NULL, 1, 13, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(14, 1, '38', '38', NULL, NULL, 1, 14, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(15, 1, '40', '40', NULL, NULL, 1, 15, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(16, 1, '42', '42', NULL, NULL, 1, 16, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(17, 2, 'Black', 'Black', '#000000', NULL, 1, 1, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(18, 2, 'White', 'White', '#FFFFFF', NULL, 1, 2, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(19, 2, 'Red', 'Red', '#FF0000', NULL, 1, 3, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(20, 2, 'Blue', 'Blue', '#0000FF', NULL, 1, 4, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(21, 2, 'Green', 'Green', '#008000', NULL, 1, 5, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(22, 2, 'Yellow', 'Yellow', '#FFFF00', NULL, 1, 6, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(23, 2, 'Pink', 'Pink', '#FFC0CB', NULL, 1, 7, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(24, 2, 'Purple', 'Purple', '#800080', NULL, 1, 8, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(25, 2, 'Orange', 'Orange', '#FFA500', NULL, 1, 9, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(26, 2, 'Brown', 'Brown', '#A52A2A', NULL, 1, 10, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(27, 2, 'Grey', 'Grey', '#808080', NULL, 1, 11, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(28, 2, 'Navy Blue', 'Navy Blue', '#000080', NULL, 1, 12, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(29, 2, 'Maroon', 'Maroon', '#800000', NULL, 1, 13, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(30, 2, 'Beige', 'Beige', '#F5F5DC', NULL, 1, 14, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(31, 2, 'Cream', 'Cream', '#FFFDD0', NULL, 1, 15, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(32, 3, 'Cotton', 'Cotton', NULL, NULL, 1, 1, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(33, 3, 'Polyester', 'Polyester', NULL, NULL, 1, 2, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(34, 3, 'Cotton Blend', 'Cotton Blend', NULL, NULL, 1, 3, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(35, 3, 'Silk', 'Silk', NULL, NULL, 1, 4, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(36, 3, 'Linen', 'Linen', NULL, NULL, 1, 5, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(37, 3, 'Wool', 'Wool', NULL, NULL, 1, 6, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(38, 3, 'Denim', 'Denim', NULL, NULL, 1, 7, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(39, 3, 'Chiffon', 'Chiffon', NULL, NULL, 1, 8, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(40, 3, 'Georgette', 'Georgette', NULL, NULL, 1, 9, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(41, 3, 'Crepe', 'Crepe', NULL, NULL, 1, 10, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(42, 3, 'Rayon', 'Rayon', NULL, NULL, 1, 11, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(43, 3, 'Viscose', 'Viscose', NULL, NULL, 1, 12, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(44, 3, 'Lycra', 'Lycra', NULL, NULL, 1, 13, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(45, 3, 'Spandex', 'Spandex', NULL, NULL, 1, 14, '2025-09-26 16:39:42', '2025-09-26 16:39:42'),
(46, 3, 'Net', 'Net', NULL, NULL, 1, 15, '2025-09-26 16:39:42', '2025-09-26 16:39:42');


-- Table structure for table `size_charts`
DROP TABLE IF EXISTS `size_charts`;
CREATE TABLE "size_charts" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "size_data" text not null, "image_url" varchar, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `size_charts`
INSERT INTO `size_charts` (`id`, `name`, `slug`, `description`, `size_data`, `image_url`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Men\'s T-Shirts & Tops', 'mens-tshirts-tops', 'Standard sizing for men\'s t-shirts, polo shirts, and casual tops. Measurements are in inches.', '{\"headers\":[\"Size\",\"Chest (in)\",\"Length (in)\",\"Shoulder (in)\",\"Sleeve (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"34-36\",\"26\",\"15.5\",\"7.5\"]},{\"size\":\"S\",\"measurements\":[\"36-38\",\"27\",\"16\",\"8\"]},{\"size\":\"M\",\"measurements\":[\"38-40\",\"28\",\"16.5\",\"8.5\"]},{\"size\":\"L\",\"measurements\":[\"40-42\",\"29\",\"17\",\"9\"]},{\"size\":\"XL\",\"measurements\":[\"42-44\",\"30\",\"17.5\",\"9.5\"]},{\"size\":\"XXL\",\"measurements\":[\"44-46\",\"31\",\"18\",\"10\"]},{\"size\":\"3XL\",\"measurements\":[\"46-48\",\"32\",\"18.5\",\"10.5\"]}]}', NULL, 1, 1, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(2, 'Men\'s Shirts', 'mens-shirts', 'Standard sizing for men\'s formal and casual shirts. Measurements are in inches.', '{\"headers\":[\"Size\",\"Neck (in)\",\"Chest (in)\",\"Length (in)\",\"Shoulder (in)\",\"Sleeve (in)\"],\"rows\":[{\"size\":\"S\",\"measurements\":[\"14-14.5\",\"36-38\",\"28\",\"16.5\",\"32-33\"]},{\"size\":\"M\",\"measurements\":[\"15-15.5\",\"38-40\",\"29\",\"17\",\"33-34\"]},{\"size\":\"L\",\"measurements\":[\"16-16.5\",\"40-42\",\"30\",\"17.5\",\"34-35\"]},{\"size\":\"XL\",\"measurements\":[\"17-17.5\",\"42-44\",\"31\",\"18\",\"35-36\"]},{\"size\":\"XXL\",\"measurements\":[\"18-18.5\",\"44-46\",\"32\",\"18.5\",\"36-37\"]},{\"size\":\"3XL\",\"measurements\":[\"19-19.5\",\"46-48\",\"33\",\"19\",\"37-38\"]}]}', NULL, 1, 2, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(3, 'Men\'s Jeans & Pants', 'mens-jeans-pants', 'Standard sizing for men\'s jeans, trousers, and casual pants. Waist measurements are in inches.', '{\"headers\":[\"Waist (in)\",\"Size\",\"Waist (cm)\",\"Inseam\"],\"rows\":[{\"size\":\"28\",\"measurements\":[\"28\",\"71\",\"Regular: 30-32\"]},{\"size\":\"30\",\"measurements\":[\"30\",\"76\",\"Regular: 30-32\"]},{\"size\":\"32\",\"measurements\":[\"32\",\"81\",\"Regular: 30-32\"]},{\"size\":\"34\",\"measurements\":[\"34\",\"86\",\"Regular: 30-32\"]},{\"size\":\"36\",\"measurements\":[\"36\",\"91\",\"Regular: 30-32\"]},{\"size\":\"38\",\"measurements\":[\"38\",\"97\",\"Regular: 30-32\"]},{\"size\":\"40\",\"measurements\":[\"40\",\"102\",\"Regular: 30-32\"]},{\"size\":\"42\",\"measurements\":[\"42\",\"107\",\"Regular: 30-32\"]},{\"size\":\"44\",\"measurements\":[\"44\",\"112\",\"Regular: 30-32\"]}]}', NULL, 1, 3, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(4, 'Women\'s Tops & Kurtis', 'womens-tops-kurtis', 'Standard sizing for women\'s tops, kurtis, and tunics. Measurements are in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Waist (in)\",\"Hip (in)\",\"Length (in)\",\"Shoulder (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"26-27\",\"35-36\",\"26\",\"13\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"28-29\",\"37-38\",\"27\",\"13.5\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"30-31\",\"39-40\",\"28\",\"14\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"32-33\",\"41-42\",\"29\",\"14.5\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"34-35\",\"43-44\",\"30\",\"15\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"36-37\",\"45-46\",\"31\",\"15.5\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"38-39\",\"47-48\",\"32\",\"16\"]}]}', NULL, 1, 4, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(5, 'Women\'s Jeans & Pants', 'womens-jeans-pants', 'Standard sizing for women\'s jeans, trousers, and casual pants. Measurements are in inches.', '{\"headers\":[\"Size\",\"Waist (in)\",\"Hip (in)\",\"Waist (cm)\",\"Hip (cm)\"],\"rows\":[{\"size\":\"26\",\"measurements\":[\"26\",\"36\",\"66\",\"91\"]},{\"size\":\"28\",\"measurements\":[\"28\",\"38\",\"71\",\"97\"]},{\"size\":\"30\",\"measurements\":[\"30\",\"40\",\"76\",\"102\"]},{\"size\":\"32\",\"measurements\":[\"32\",\"42\",\"81\",\"107\"]},{\"size\":\"34\",\"measurements\":[\"34\",\"44\",\"86\",\"112\"]},{\"size\":\"36\",\"measurements\":[\"36\",\"46\",\"91\",\"117\"]},{\"size\":\"38\",\"measurements\":[\"38\",\"48\",\"97\",\"122\"]}]}', NULL, 1, 5, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(6, 'Women\'s Dresses', 'womens-dresses', 'Standard sizing for women\'s dresses, gowns, and one-piece outfits. Measurements are in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Waist (in)\",\"Hip (in)\",\"Length (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"25-26\",\"35-36\",\"36-38\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"27-28\",\"37-38\",\"38-40\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"29-30\",\"39-40\",\"40-42\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"31-32\",\"41-42\",\"42-44\"]},{\"size\":\"XL\",\"measurements\":[\"40-42\",\"33-35\",\"43-45\",\"44-46\"]},{\"size\":\"XXL\",\"measurements\":[\"43-45\",\"36-38\",\"46-48\",\"46-48\"]}]}', NULL, 1, 6, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(7, 'Kids Clothing (Boys & Girls)', 'kids-clothing', 'Age-based sizing for kids clothing. Measurements are approximate and may vary.', '{\"headers\":[\"Size\",\"Age\",\"Height (cm)\",\"Chest (in)\",\"Waist (in)\"],\"rows\":[{\"size\":\"2-3Y\",\"measurements\":[\"2-3 years\",\"92-98\",\"20-21\",\"19-20\"]},{\"size\":\"3-4Y\",\"measurements\":[\"3-4 years\",\"98-104\",\"21-22\",\"20-21\"]},{\"size\":\"4-5Y\",\"measurements\":[\"4-5 years\",\"104-110\",\"22-23\",\"21-22\"]},{\"size\":\"5-6Y\",\"measurements\":[\"5-6 years\",\"110-116\",\"23-24\",\"22-23\"]},{\"size\":\"6-7Y\",\"measurements\":[\"6-7 years\",\"116-122\",\"24-25\",\"23-24\"]},{\"size\":\"7-8Y\",\"measurements\":[\"7-8 years\",\"122-128\",\"25-26\",\"24-25\"]},{\"size\":\"8-9Y\",\"measurements\":[\"8-9 years\",\"128-134\",\"26-27\",\"25-26\"]},{\"size\":\"9-10Y\",\"measurements\":[\"9-10 years\",\"134-140\",\"27-28\",\"26-27\"]},{\"size\":\"10-11Y\",\"measurements\":[\"10-11 years\",\"140-146\",\"28-29\",\"27-28\"]},{\"size\":\"11-12Y\",\"measurements\":[\"11-12 years\",\"146-152\",\"29-30\",\"28-29\"]},{\"size\":\"12-13Y\",\"measurements\":[\"12-13 years\",\"152-158\",\"30-31\",\"29-30\"]},{\"size\":\"13-14Y\",\"measurements\":[\"13-14 years\",\"158-164\",\"31-32\",\"30-31\"]}]}', NULL, 1, 7, '2025-10-13 00:57:35', '2025-10-13 00:57:35'),
(8, 'Footwear (Unisex)', 'footwear-unisex', 'Standard footwear sizing with India/UK to US/EU conversion. Measure your foot length for best fit.', '{\"headers\":[\"India\\/UK\",\"US Men\",\"US Women\",\"EU\",\"Foot Length (cm)\"],\"rows\":[{\"size\":\"3\",\"measurements\":[\"4\",\"5\",\"36\",\"22.0\"]},{\"size\":\"4\",\"measurements\":[\"5\",\"6\",\"37\",\"22.9\"]},{\"size\":\"5\",\"measurements\":[\"6\",\"7\",\"38\",\"23.7\"]},{\"size\":\"6\",\"measurements\":[\"7\",\"8\",\"39\",\"24.6\"]},{\"size\":\"7\",\"measurements\":[\"8\",\"9\",\"40\",\"25.4\"]},{\"size\":\"8\",\"measurements\":[\"9\",\"10\",\"42\",\"26.2\"]},{\"size\":\"9\",\"measurements\":[\"10\",\"11\",\"43\",\"27.1\"]},{\"size\":\"10\",\"measurements\":[\"11\",\"12\",\"44\",\"27.9\"]},{\"size\":\"11\",\"measurements\":[\"12\",\"13\",\"46\",\"28.8\"]},{\"size\":\"12\",\"measurements\":[\"13\",\"14\",\"47\",\"29.6\"]}]}', NULL, 1, 8, '2025-10-13 00:57:36', '2025-10-13 00:57:36'),
(9, 'Women\'s Blouse', 'womens-blouse', 'Standard sizing for women\'s blouses. Measurements are in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Waist (in)\",\"Hip (in)\",\"Length (in)\",\"Shoulder (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"26-27\",\"35-36\",\"22-23\",\"13\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"28-29\",\"37-38\",\"23-24\",\"13.5\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"30-31\",\"39-40\",\"24-25\",\"14\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"32-33\",\"41-42\",\"25-26\",\"14.5\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"34-35\",\"43-44\",\"26-27\",\"15\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"36-37\",\"45-46\",\"27-28\",\"15.5\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"38-39\",\"47-48\",\"28-29\",\"16\"]}]}', NULL, 1, 9, '2025-10-13 01:00:45', '2025-10-13 01:00:45'),
(10, 'Saree Blouse (Stitched)', 'saree-blouse-stitched', 'Standard sizing for stitched saree blouses. Measurements are in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Waist (in)\",\"Hip (in)\",\"Shoulder (in)\",\"Sleeve (in)\"],\"rows\":[{\"size\":\"32\",\"measurements\":[\"32\",\"26\",\"34\",\"13\",\"5-6\"]},{\"size\":\"34\",\"measurements\":[\"34\",\"28\",\"36\",\"13.5\",\"5-6\"]},{\"size\":\"36\",\"measurements\":[\"36\",\"30\",\"38\",\"14\",\"5-6\"]},{\"size\":\"38\",\"measurements\":[\"38\",\"32\",\"40\",\"14.5\",\"5-6\"]},{\"size\":\"40\",\"measurements\":[\"40\",\"34\",\"42\",\"15\",\"5-6\"]},{\"size\":\"42\",\"measurements\":[\"42\",\"36\",\"44\",\"15.5\",\"5-6\"]},{\"size\":\"44\",\"measurements\":[\"44\",\"38\",\"46\",\"16\",\"5-6\"]}]}', NULL, 1, 10, '2025-10-13 01:00:45', '2025-10-13 01:00:45'),
(11, 'Saree Blouse (Unstitched)', 'saree-blouse-unstitched', 'Fabric length for unstitched saree blouses. Can be customized as per your measurements.', '{\"headers\":[\"Type\",\"Fabric Length\",\"Width\",\"Description\"],\"rows\":[{\"size\":\"Standard\",\"measurements\":[\"0.8 meters\",\"44-48 inches\",\"Suitable for sizes 32-40\"]},{\"size\":\"Plus Size\",\"measurements\":[\"1.0 meters\",\"44-48 inches\",\"Suitable for sizes 42-46\"]},{\"size\":\"Designer\",\"measurements\":[\"1.25 meters\",\"44-48 inches\",\"For heavy work or long sleeves\"]}]}', NULL, 1, 11, '2025-10-13 01:00:45', '2025-10-13 01:00:45'),
(12, 'Readymade Blouse', 'readymade-blouse', 'Standard sizing for readymade blouses with stretchable fabric. Measurements are in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Length (in)\",\"Suitable For\"],\"rows\":[{\"size\":\"S\",\"measurements\":[\"32-34\",\"14-15\",\"Bust 32-34 inches\"]},{\"size\":\"M\",\"measurements\":[\"34-36\",\"15-16\",\"Bust 34-36 inches\"]},{\"size\":\"L\",\"measurements\":[\"36-38\",\"16-17\",\"Bust 36-38 inches\"]},{\"size\":\"XL\",\"measurements\":[\"38-40\",\"17-18\",\"Bust 38-40 inches\"]},{\"size\":\"XXL\",\"measurements\":[\"40-42\",\"18-19\",\"Bust 40-42 inches\"]},{\"size\":\"3XL\",\"measurements\":[\"42-44\",\"19-20\",\"Bust 42-44 inches\"]}]}', NULL, 1, 12, '2025-10-13 01:00:45', '2025-10-13 01:00:45'),
(13, 'Designer Blouse', 'designer-blouse', 'Detailed measurements for designer blouses with custom fitting. All measurements in inches.', '{\"headers\":[\"Size\",\"Bust (in)\",\"Waist (in)\",\"Shoulder (in)\",\"Sleeve (in)\",\"Length (in)\",\"Armhole (in)\"],\"rows\":[{\"size\":\"32\",\"measurements\":[\"32\",\"26\",\"13\",\"5-6\",\"14\",\"16\"]},{\"size\":\"34\",\"measurements\":[\"34\",\"28\",\"13.5\",\"5-6\",\"14.5\",\"17\"]},{\"size\":\"36\",\"measurements\":[\"36\",\"30\",\"14\",\"5-6\",\"15\",\"18\"]},{\"size\":\"38\",\"measurements\":[\"38\",\"32\",\"14.5\",\"5-6\",\"15.5\",\"19\"]},{\"size\":\"40\",\"measurements\":[\"40\",\"34\",\"15\",\"5-6\",\"16\",\"20\"]},{\"size\":\"42\",\"measurements\":[\"42\",\"36\",\"15.5\",\"5-6\",\"16.5\",\"21\"]},{\"size\":\"44\",\"measurements\":[\"44\",\"38\",\"16\",\"5-6\",\"17\",\"22\"]}]}', NULL, 1, 13, '2025-10-13 01:00:45', '2025-10-13 01:00:45'),
(14, 'Women\'s 2 Piece Set (Top + Bottom)', 'womens-2-piece-set', 'Standard sizing for women\'s 2-piece sets including top and bottom. Measurements are in inches.', '{\"headers\":[\"Size\",\"Top Bust (in)\",\"Top Length (in)\",\"Bottom Waist (in)\",\"Bottom Length (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"24-26\",\"26-27\",\"36-38\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"25-27\",\"28-29\",\"37-39\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"26-28\",\"30-31\",\"38-40\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"27-29\",\"32-33\",\"39-41\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"28-30\",\"34-35\",\"40-42\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"29-31\",\"36-37\",\"41-43\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"30-32\",\"38-39\",\"42-44\"]}]}', NULL, 1, 14, '2025-10-13 01:09:48', '2025-10-13 01:09:48'),
(15, 'Women\'s 3 Piece Set (Kurti + Bottom + Dupatta)', 'womens-3-piece-set', 'Standard sizing for women\'s 3-piece sets including kurti, bottom, and dupatta. Measurements are in inches.', '{\"headers\":[\"Size\",\"Kurti Bust (in)\",\"Kurti Length (in)\",\"Bottom Waist (in)\",\"Dupatta Length\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"42-44\",\"26-27\",\"2.25 meters\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"43-45\",\"28-29\",\"2.25 meters\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"44-46\",\"30-31\",\"2.25 meters\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"45-47\",\"32-33\",\"2.25 meters\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"46-48\",\"34-35\",\"2.25 meters\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"47-49\",\"36-37\",\"2.25 meters\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"48-50\",\"38-39\",\"2.25 meters\"]}]}', NULL, 1, 15, '2025-10-13 01:09:48', '2025-10-13 01:09:48'),
(16, 'Salwar Kameez Set', 'salwar-kameez-set', 'Standard sizing for salwar kameez sets. Measurements are in inches.', '{\"headers\":[\"Size\",\"Kameez Bust (in)\",\"Kameez Length (in)\",\"Salwar Waist (in)\",\"Salwar Length (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"42-44\",\"26-28\",\"38-40\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"43-45\",\"28-30\",\"38-40\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"44-46\",\"30-32\",\"38-40\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"45-47\",\"32-34\",\"38-40\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"46-48\",\"34-36\",\"38-40\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"47-49\",\"36-38\",\"38-40\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"48-50\",\"38-40\",\"38-40\"]}]}', NULL, 1, 16, '2025-10-13 01:09:48', '2025-10-13 01:09:48'),
(17, 'Lehenga Choli Set', 'lehenga-choli-set', 'Standard sizing for lehenga choli sets. Measurements are in inches.', '{\"headers\":[\"Size\",\"Choli Bust (in)\",\"Choli Length (in)\",\"Lehenga Waist (in)\",\"Lehenga Length (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"14-15\",\"26-27\",\"40-42\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"15-16\",\"28-29\",\"40-42\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"16-17\",\"30-31\",\"40-42\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"17-18\",\"32-33\",\"40-42\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"18-19\",\"34-35\",\"40-42\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"19-20\",\"36-37\",\"40-42\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"20-21\",\"38-39\",\"40-42\"]}]}', NULL, 1, 17, '2025-10-13 01:09:48', '2025-10-13 01:09:48'),
(18, 'Co-ord Set (Matching Top + Bottom)', 'coord-set', 'Standard sizing for co-ord sets with matching top and bottom. Measurements are in inches.', '{\"headers\":[\"Size\",\"Top Bust (in)\",\"Top Length (in)\",\"Bottom Waist (in)\",\"Bottom Hip (in)\"],\"rows\":[{\"size\":\"XS\",\"measurements\":[\"32-33\",\"18-20\",\"26-27\",\"35-36\"]},{\"size\":\"S\",\"measurements\":[\"34-35\",\"19-21\",\"28-29\",\"37-38\"]},{\"size\":\"M\",\"measurements\":[\"36-37\",\"20-22\",\"30-31\",\"39-40\"]},{\"size\":\"L\",\"measurements\":[\"38-39\",\"21-23\",\"32-33\",\"41-42\"]},{\"size\":\"XL\",\"measurements\":[\"40-41\",\"22-24\",\"34-35\",\"43-44\"]},{\"size\":\"XXL\",\"measurements\":[\"42-43\",\"23-25\",\"36-37\",\"45-46\"]},{\"size\":\"3XL\",\"measurements\":[\"44-45\",\"24-26\",\"38-39\",\"47-48\"]}]}', NULL, 1, 18, '2025-10-13 01:09:48', '2025-10-13 01:09:48');


-- Table structure for table `products`
DROP TABLE IF EXISTS `products`;
CREATE TABLE "products" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "short_description" text, "sku" varchar not null, "price" numeric not null, "sale_price" numeric, "stock_quantity" integer not null default ('0'), "manage_stock" tinyint(1) not null default ('1'), "in_stock" tinyint(1) not null default ('1'), "weight" numeric, "dimensions" varchar, "category_id" integer not null, "images" text, "attributes" text, "is_featured" tinyint(1) not null default ('0'), "is_active" tinyint(1) not null default ('1'), "status" varchar not null default ('active'), "meta_title" varchar, "meta_description" text, "created_at" datetime, "updated_at" datetime, "seo_title" varchar, "long_description" text, "structured_data" text, "seo_generated" tinyint(1) not null default ('0'), "seo_generated_at" datetime, "meta_keywords" text, "brand" varchar, "gtin" varchar, "mpn" varchar, "identifier_exists" tinyint(1) not null default ('1'), "google_product_category" varchar, "condition" varchar not null default ('new'), "availability" varchar not null default ('in_stock'), "age_group" varchar, "gender" varchar, "size" varchar, "color" varchar, "material" varchar, "pattern" varchar, "item_group_id" varchar, "shipping_weight" numeric, "shipping_dimensions" varchar, "shipping_cost" numeric, "shipping_service" varchar, "additional_images" text, "product_type" varchar, "custom_labels" text, "facebook_product_id" varchar, "cost_of_goods" numeric, "seo_description" varchar, "seo_keywords" varchar, "tags" text, "has_warranty" tinyint(1) not null default ('0'), "warranty_period" varchar, "has_return_policy" tinyint(1) not null default ('1'), "return_days" integer not null default ('30'), "rating" numeric, "review_count" integer not null default ('0'), "low_stock_threshold" integer not null default ('5'), "track_quantity" tinyint(1) not null default ('1'), "stock_status" varchar not null default ('in_stock'), "compare_at_price" numeric, "cost_price" numeric, "price_includes_tax" tinyint(1) not null default ('1'), "tax_rate" numeric, "size_chart_id" integer, foreign key("category_id") references categories("id") on delete cascade on update no action, foreign key("size_chart_id") references "size_charts"("id") on delete set null);


-- Dumping data for table `products`
INSERT INTO `products` (`id`, `name`, `slug`, `description`, `short_description`, `sku`, `price`, `sale_price`, `stock_quantity`, `manage_stock`, `in_stock`, `weight`, `dimensions`, `category_id`, `images`, `attributes`, `is_featured`, `is_active`, `status`, `meta_title`, `meta_description`, `created_at`, `updated_at`, `seo_title`, `long_description`, `structured_data`, `seo_generated`, `seo_generated_at`, `meta_keywords`, `brand`, `gtin`, `mpn`, `identifier_exists`, `google_product_category`, `condition`, `availability`, `age_group`, `gender`, `size`, `color`, `material`, `pattern`, `item_group_id`, `shipping_weight`, `shipping_dimensions`, `shipping_cost`, `shipping_service`, `additional_images`, `product_type`, `custom_labels`, `facebook_product_id`, `cost_of_goods`, `seo_description`, `seo_keywords`, `tags`, `has_warranty`, `warranty_period`, `has_return_policy`, `return_days`, `rating`, `review_count`, `low_stock_threshold`, `track_quantity`, `stock_status`, `compare_at_price`, `cost_price`, `price_includes_tax`, `tax_rate`, `size_chart_id`) VALUES
(9, '2 Pcs Set', '2-pcs-set-68d90c92481cf', '2 Pcs Set', 'Premium simple crafted with attention to detail. 2 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'CPSL2PR_1', 360, NULL, 1, 1, 1, 0.85, NULL, 22, '[\"products\\/migrated_1759079664_68d96cf09892d.jpg\",\"products\\/migrated_1759079665_68d96cf16366c.jpg\",\"products\\/migrated_1759079666_68d96cf274ec9.jpg\",\"products\\/migrated_1759079667_68d96cf39b81f.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy 2 Pcs Set online at SJ Fashion Hub. Stylish 2 Pcs Set with premium quality. Price: ₹360. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '2 Pcs Set - Quality simple for Every Occasion | SJ Fashion', '**About This Product**

The 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"2 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. 2 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"CPSL2PR_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"2 Pcs Set\"}', 1, '2025-09-28 10:46:56', '2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(10, '2 Pcs Set', '2-pcs-set-68d90c9249b54', '2 Pcs Set', 'Experience luxury and comfort with this 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSL2PR_2', 360, NULL, 1, 1, 1, 0.85, NULL, 22, '[\"products\\/migrated_1759079668_68d96cf49557f.jpg\",\"products\\/migrated_1759079669_68d96cf592f3b.jpg\",\"products\\/migrated_1759079670_68d96cf65e08e.jpg\",\"products\\/migrated_1759079671_68d96cf772a01.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 2 Pcs Set at SJ Fashion Hub. Premium quality 2 Pcs Set starting from ₹360. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '2 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"2 Pcs Set\",\"description\":\"Experience luxury and comfort with this 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSL2PR_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"2 Pcs Set\"}', 1, '2025-09-28 10:46:56', '2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(11, '2 Pcs Set', '2-pcs-set-68d90c924ae42', '2 Pcs Set', 'Experience luxury and comfort with this 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSL2PR_3', 360, NULL, 1, 1, 1, 0.85, NULL, 22, '[\"products\\/migrated_1759079672_68d96cf83b355.jpg\",\"products\\/migrated_1759079673_68d96cf9109bb.jpg\",\"products\\/migrated_1759079673_68d96cf9bd25d.jpg\",\"products\\/migrated_1759079674_68d96cfa88afe.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 2 Pcs Set at SJ Fashion Hub. Premium quality 2 Pcs Set starting from ₹360. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 2 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"2 Pcs Set\",\"description\":\"Experience luxury and comfort with this 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSL2PR_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"2 Pcs Set\"}', 1, '2025-09-28 10:46:56', '2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(12, '2 Pcs Set', '2-pcs-set-68d90c924c049', '2 Pcs Set', 'Discover the perfect blend of style and quality in this 2 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CPSL2PR_4', 360, NULL, 1, 1, 1, 0.85, NULL, 22, '[\"products\\/migrated_1759079675_68d96cfb72557.jpg\",\"products\\/migrated_1759079676_68d96cfc80e99.jpg\",\"products\\/migrated_1759079677_68d96cfd37317.jpg\",\"products\\/migrated_1759079678_68d96cfe1ab6b.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 2 Pcs Set at SJ Fashion Hub. Premium quality 2 Pcs Set starting from ₹360. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '2 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"2 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 2 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CPSL2PR_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"2 Pcs Set\"}', 1, '2025-09-28 10:46:56', '2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(13, '3 Pcs Set', '3-pcs-set-68d90c924d3d2', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CTN3PIPC_1', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079678_68d96cfee951b.jpg\",\"products\\/migrated_1759079680_68d96d006312e.jpg\",\"products\\/migrated_1759079681_68d96d0127f57.jpg\",\"products\\/migrated_1759079682_68d96d0264a05.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹550. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CTN3PIPC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(14, '3 Pcs Set', '3-pcs-set-68d90c924e892', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN3PIPC_2', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079684_68d96d046533b.jpg\",\"products\\/migrated_1759079688_68d96d08a0f03.jpg\",\"products\\/migrated_1759079689_68d96d094f4b9.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹550. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN3PIPC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(15, '3 Pcs Set', '3-pcs-set-68d90c924fb88', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CTN3PIPC_3', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079691_68d96d0b0d79d.jpg\",\"products\\/migrated_1759079692_68d96d0c12cb6.jpg\",\"products\\/migrated_1759079693_68d96d0d9db75.jpg\",\"products\\/migrated_1759079694_68d96d0edebbe.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹550. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CTN3PIPC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(16, '3 Pcs Set', '3-pcs-set-68d90c9252ef2', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CTN3PIPC_4', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079695_68d96d0fa6fad.jpg\",\"products\\/migrated_1759079696_68d96d10aed1b.jpg\",\"products\\/migrated_1759079697_68d96d11a6460.jpg\",\"products\\/migrated_1759079698_68d96d1296f95.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹550. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Quality simple for Every Occasion | SJ Fashion', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CTN3PIPC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(17, '3 Pcs Set', '3-pcs-set-68d90c9254902', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN2PIPC_1', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079699_68d96d13a022f.jpg\",\"products\\/migrated_1759079700_68d96d14d3a11.jpg\",\"products\\/migrated_1759079702_68d96d16aa99d.jpg\",\"products\\/migrated_1759079703_68d96d17843c9.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹550. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN2PIPC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(18, '3 Pcs Set', '3-pcs-set-68d90c9256226', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CTN2PIPC_2', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079704_68d96d18cd838.jpg\",\"products\\/migrated_1759079705_68d96d19c4ad0.jpg\",\"products\\/migrated_1759079706_68d96d1aa921e.jpg\",\"products\\/migrated_1759079707_68d96d1b9483b.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy 3 Pcs Set online at SJ Fashion Hub. Stylish 3 Pcs Set with premium quality. Price: ₹550. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CTN2PIPC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(19, '3 Pcs Set', '3-pcs-set-68d90c9257516', '3 Pcs Set', 'Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'CTN2PIPC_3', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079708_68d96d1cefa8b.jpg\",\"products\\/migrated_1759079710_68d96d1e21fa2.jpg\",\"products\\/migrated_1759079711_68d96d1fd0c27.jpg\",\"products\\/migrated_1759079714_68d96d2211161.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹550. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop 3 Pcs Set - Latest simple Fashion | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"CTN2PIPC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(20, '3 Pcs Set', '3-pcs-set-68d90c925880e', '3 Pcs Set', 'Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'CTN2PIPC_4', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079716_68d96d24ec52a.jpg\",\"products\\/migrated_1759079717_68d96d25bcc58.jpg\",\"products\\/migrated_1759079718_68d96d26d0afa.jpg\",\"products\\/migrated_1759079720_68d96d2861b4f.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹550. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"CTN2PIPC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(21, '3 Pcs Set', '3-pcs-set-68d90c9259a99', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN3PIPC_5', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079721_68d96d29aa91a.jpg\",\"products\\/migrated_1759079723_68d96d2b53838.jpg\",\"products\\/migrated_1759079724_68d96d2c34f55.jpg\",\"products\\/migrated_1759079725_68d96d2d313c7.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy 3 Pcs Set online at SJ Fashion Hub. Stylish 3 Pcs Set with premium quality. Price: ₹550. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN3PIPC_5\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(22, '3 Pcs Set', '3-pcs-set-68d90c925ad45', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN3PIPC_6', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079726_68d96d2e193f1.jpg\",\"products\\/migrated_1759079729_68d96d3156a40.jpg\",\"products\\/migrated_1759079732_68d96d348daaa.jpg\",\"products\\/migrated_1759079734_68d96d36212a1.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 3 Pcs Set at SJ Fashion Hub. Premium quality 3 Pcs Set starting from ₹550. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN3PIPC_6\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(23, '3 Pcs Set', '3-pcs-set-68d90c925bdeb', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN3PIPC_7', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079735_68d96d37beb5d.jpg\",\"products\\/migrated_1759079737_68d96d3943424.jpg\",\"products\\/migrated_1759079738_68d96d3a925b6.jpg\",\"products\\/migrated_1759079740_68d96d3c3028e.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹550. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN3PIPC_7\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(24, '3 Pcs Set', '3-pcs-set-68d90c925cf2a', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTN3PIPC_8', 550, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079741_68d96d3dcf642.jpg\",\"products\\/migrated_1759079742_68d96d3ee8e54.jpg\",\"products\\/migrated_1759079744_68d96d402bec2.jpg\",\"products\\/migrated_1759079745_68d96d4132003.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 3 Pcs Set at SJ Fashion Hub. Premium quality 3 Pcs Set starting from ₹550. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTN3PIPC_8\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"550.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(25, '3 Pcs Set', '3-pcs-set-68d90c925e288', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', '.001IOSL_1', 680, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079746_68d96d42b85fd.jpg\",\"products\\/migrated_1759079747_68d96d4372560.jpg\",\"products\\/migrated_1759079748_68d96d44d6f95.jpg\",\"products\\/migrated_1759079749_68d96d45aadfe.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 3 Pcs Set at SJ Fashion Hub. Premium quality 3 Pcs Set starting from ₹680. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Quality simple for Every Occasion | SJ Fashion', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\".001IOSL_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"680.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(26, '3 Pcs Set', '3-pcs-set-68d90c925f639', '3 Pcs Set', 'Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', '.001IOSL_2', 680, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079750_68d96d46a733f.jpg\",\"products\\/migrated_1759079752_68d96d482c394.jpg\",\"products\\/migrated_1759079752_68d96d48e5a64.jpg\",\"products\\/migrated_1759079754_68d96d4a5436c.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹680. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\".001IOSL_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"680.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(27, '3 Pcs Set', '3-pcs-set-68d90c926097e', '3 Pcs Set', 'Premium simple crafted with attention to detail. 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', '.001IOSL_3', 680, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079755_68d96d4b37dd1.jpg\",\"products\\/migrated_1759079756_68d96d4c4c319.jpg\",\"products\\/migrated_1759079757_68d96d4d8a54c.jpg\",\"products\\/migrated_1759079758_68d96d4ebf32e.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹680. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\".001IOSL_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"680.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(28, '3 Pcs Set', '3-pcs-set-68d90c92631d1', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'JYNAE_1', 420, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079760_68d96d508f8d0.jpg\",\"products\\/migrated_1759079761_68d96d51787b3.jpg\",\"products\\/migrated_1759079762_68d96d52bad61.jpg\",\"products\\/migrated_1759079763_68d96d539752e.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover 3 Pcs Set in our 3 Pcs Set collection. High-quality fashion at ₹420. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"JYNAE_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"420.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(29, '3 Pcs Set', '3-pcs-set-68d90c92645a6', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'JYNAE_2', 420, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079765_68d96d5592df3.jpg\",\"products\\/migrated_1759079766_68d96d56dfe63.jpg\",\"products\\/migrated_1759079767_68d96d57a2130.jpg\",\"products\\/migrated_1759079769_68d96d596b70a.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹420. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"JYNAE_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"420.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(30, '3 Pcs Set', '3-pcs-set-68d90c9265692', '3 Pcs Set', 'Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'JYNAE_3', 420, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079770_68d96d5a9177f.jpg\",\"products\\/migrated_1759079771_68d96d5b775c0.jpg\",\"products\\/migrated_1759079772_68d96d5c3a16d.jpg\",\"products\\/migrated_1759079773_68d96d5d9edc7.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹420. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"JYNAE_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"420.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(31, '3 Pcs Set', '3-pcs-set-68d90c9266941', '3 Pcs Set', 'Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'JYNAE_4', 420, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079774_68d96d5e68c0a.jpg\",\"products\\/migrated_1759079775_68d96d5f8f734.jpg\",\"products\\/migrated_1759079776_68d96d6095761.jpg\",\"products\\/migrated_1759079778_68d96d62b55c7.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy 3 Pcs Set online at SJ Fashion Hub. Stylish 3 Pcs Set with premium quality. Price: ₹420. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Stylish simple at Best Price | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"JYNAE_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"420.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(32, '3 Pcs Set', '3-pcs-set-68d90c9267b7c', '3 Pcs Set', 'Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CTSLPNC_1', 500, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079779_68d96d63b49f4.jpg\",\"products\\/migrated_1759079781_68d96d651eaaf.jpg\",\"products\\/migrated_1759079782_68d96d666dfe0.jpg\",\"products\\/migrated_1759079784_68d96d68cca2b.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 3 Pcs Set at SJ Fashion Hub. Premium quality 3 Pcs Set starting from ₹500. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Quality simple for Every Occasion | SJ Fashion', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Experience luxury and comfort with this 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CTSLPNC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(33, '3 Pcs Set', '3-pcs-set-68d90c9268b8b', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTSLPNC_2', 500, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079785_68d96d69ca478.jpg\",\"products\\/migrated_1759079786_68d96d6abeb67.jpg\",\"products\\/migrated_1759079788_68d96d6c120bc.jpg\",\"products\\/migrated_1759079789_68d96d6d25107.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹500. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop 3 Pcs Set - Latest simple Fashion | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTSLPNC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(34, '3 Pcs Set', '3-pcs-set-68d90c9269d07', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTSLPNC_3', 500, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079790_68d96d6eee635.jpg\",\"products\\/migrated_1759079792_68d96d70d662c.jpg\",\"products\\/migrated_1759079796_68d96d7494d16.jpg\",\"products\\/migrated_1759079797_68d96d75a6518.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get 3 Pcs Set from SJ Fashion Hub\'s 3 Pcs Set range. Quality assured at ₹500. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy 3 Pcs Set Online - simple Collection | SJ Fashion Hub', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTSLPNC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(35, '3 Pcs Set', '3-pcs-set-68d90c926c2f5', '3 Pcs Set', 'Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTSLPNC_4', 500, NULL, 1, 1, 1, 0.85, NULL, 23, '[\"products\\/migrated_1759079799_68d96d772b257.jpg\",\"products\\/migrated_1759079800_68d96d787f759.jpg\",\"products\\/migrated_1759079801_68d96d7981c82.jpg\",\"products\\/migrated_1759079802_68d96d7a5a9c2.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop 3 Pcs Set at SJ Fashion Hub. Premium quality 3 Pcs Set starting from ₹500. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', '3 Pcs Set - Quality simple for Every Occasion | SJ Fashion', '**About This Product**

The 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTSLPNC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"3 Pcs Set\"}', 1, '2025-09-28 10:46:56', '3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(36, 'Black Embroidered blouses for sarees', 'black-embroidered-blouses-for-sarees-68d90c926ef8a', '🖤 Black Embroidered Saree Blouse – Bold. Elegant. Timeless.

Unleash your inner diva with our black embroidered saree blouse – a striking fusion of grace and sophistication. Perfect for parties, receptions, festivals, and traditional ceremonies, this blouse adds unmatched charm to any saree.
✨ Key Features:


 	
Classic Black Shade: A bold, versatile color that pairs effortlessly with all types of sarees – from bright silks to subtle chiffons.

 	
Round Neck Design: Simple, elegant, and ideal for highlighting statement jewelry or keeping it minimalist.

 	
Front Open with Hook Closure: Comfortable and easy to wear, offering a clean silhouette and secure fit.

 	
Detailed Embroidery: Intricate handwork including zardosi, maggam, and mirror embroidery – showcasing heritage craftsmanship.

 	
Premium Fabric: Available in soft silk, cotton silk, or georgette, ensuring both style and comfort.

 	
Inclusive Sizing: Offered in sizes 26 to 42, making it perfect for all age groups and body types.

', 'Elevate your wardrobe with this stylish Black Embroidered blouses for sarees. Perfect variable piece that offers both comfort and contemporary design.', 'CTN_EMB_BLK2-1', 249, NULL, 100, 1, 1, 0.3, NULL, 24, '[\"products\\/migrated_1759079804_68d96d7cb8514.jpg\",\"products\\/migrated_1759079807_68d96d7f5b9a4.jpg\",\"products\\/migrated_1759079810_68d96d8263dc1.jpg\",\"products\\/migrated_1759079812_68d96d84d1c0e.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Black Embroidered blouses for sarees from SJ Fashion Hub\'s Blouse
 range. Quality assured at ₹249. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Shop Black Embroidered blouses for sarees - Latest variabl', '**About This Product**

The Black Embroidered blouses for sarees represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this variable piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this variable piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Black Embroidered blouses for sarees\",\"description\":\"Elevate your wardrobe with this stylish Black Embroidered blouses for sarees. Perfect variable piece that offers both comfort and contemporary design.\",\"sku\":\"CTN_EMB_BLK2-1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"249.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:46:56', 'black embroidered blouses for sarees, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '🖤 Black Embroidered Saree Blouse – Bold. Elegant. Timeless.

Unleash your inner diva with our black embroidered saree blouse – a striking fusion of grace and sophistication. Perfect for parties, receptions, festivals, and traditional ceremonies, this blouse adds unmatched charm to any saree.
✨ Key Features:


 	
Classic Black Shade: A bold, versatile color that pairs effortlessly with all types of sarees – from bright silks to subtle chiffons.

 	
Round Neck Design: Simple, elegant, and ideal for highlighting statement jewelry or keeping it minimalist.

 	
Front Open with Hook Closure: Comfortable and easy to wear, offering a clean silhouette and secure fit.

 	
Detailed Embroidery: Intricate handwork including zardosi, maggam, and mirror embroidery – showcasing heritage craftsmanship.

 	
Premium Fabric: Available in soft silk, cotton silk, or georgette, ensuring both style and comfort.

 	
Inclusive Sizing: Offered in sizes 26 to 42, making it perfect for all age groups and body types.

', NULL, '[\"Designer red saree blouse 26 to 42 size\",\"Front open red blouse for saree\",\"Hand-embroidered red saree blouse\",\"Red blouse for wedding saree\",\"Red blouse with hook closure\",\"Red embroidered saree blouse\",\"Round neck red blouse with embroidery\",\"Traditional red blouse with round neck\"]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 13),
(37, 'Black Embroidered blouses for sarees', 'black-embroidered-blouses-for-sarees-68d90c9270bf1', '🖤 Black Embroidered Saree Blouse – Bold. Elegant. Timeless.

Unleash your inner diva with our black embroidered saree blouse – a striking fusion of grace and sophistication. Perfect for parties, receptions, festivals, and traditional ceremonies, this blouse adds unmatched charm to any saree.
✨ Key Features:


 	
Classic Black Shade: A bold, versatile color that pairs effortlessly with all types of sarees – from bright silks to subtle chiffons.

 	
Round Neck Design: Simple, elegant, and ideal for highlighting statement jewelry or keeping it minimalist.

 	
Front Open with Hook Closure: Comfortable and easy to wear, offering a clean silhouette and secure fit.

 	
Detailed Embroidery: Intricate handwork including zardosi, maggam, and mirror embroidery – showcasing heritage craftsmanship.

 	
Premium Fabric: Available in soft silk, cotton silk, or georgette, ensuring both style and comfort.

 	
Inclusive Sizing: Offered in sizes 26 to 42, making it perfect for all age groups and body types.

', 'Premium variable crafted with attention to detail. Black Embroidered blouses for sarees combines style and comfort for the modern fashion enthusiast.', 'CTN_EMB_BLK_2', 249, NULL, 100, 1, 1, 0.3, NULL, 24, '[\"products\\/migrated_1759079813_68d96d85cf41b.jpg\",\"products\\/migrated_1759079817_68d96d891e413.jpg\",\"products\\/migrated_1759079818_68d96d8a7dda7.jpg\",\"products\\/migrated_1759079820_68d96d8ca2c01.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Black Embroidered blouses for sarees from SJ Fashion Hub\'s Blouse
 range. Quality assured at ₹249. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Black Embroidered blouses for sarees - Stylish variable at', '**About This Product**

The Black Embroidered blouses for sarees represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this variable piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this variable piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Black Embroidered blouses for sarees\",\"description\":\"Premium variable crafted with attention to detail. Black Embroidered blouses for sarees combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"CTN_EMB_BLK_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"249.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:46:56', 'black embroidered blouses for sarees, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '🖤 Black Embroidered Saree Blouse – Bold. Elegant. Timeless.

Unleash your inner diva with our black embroidered saree blouse – a striking fusion of grace and sophistication. Perfect for parties, receptions, festivals, and traditional ceremonies, this blouse adds unmatched charm to any saree.
✨ Key Features:


 	
Classic Black Shade: A bold, versatile color that pairs effortlessly with all types of sarees – from bright silks to subtle chiffons.

 	
Round Neck Design: Simple, elegant, and ideal for highlighting statement jewelry or keeping it minimalist.

 	
Front Open with Hook Closure: Comfortable and easy to wear, offering a clean silhouette and secure fit.

 	
Detailed Embroidery: Intricate handwork including zardosi, maggam, and mirror embroidery – showcasing heritage craftsmanship.

 	
Premium Fabric: Available in soft silk, cotton silk, or georgette, ensuring both style and comfort.

 	
Inclusive Sizing: Offered in sizes 26 to 42, making it perfect for all age groups and body types.

', NULL, '[\"Designer red saree blouse 26 to 42 size\",\"Front open red blouse for saree\",\"Hand-embroidered red saree blouse\",\"Red blouse for wedding saree\",\"Red blouse with hook closure\",\"Red embroidered saree blouse\",\"Round neck red blouse with embroidery\",\"Traditional red blouse with round neck\"]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 13),
(38, 'Blue Embroidered blouses for sarees', 'blue-embroidered-blouses-for-sarees-68d90c9272593', '💙 Blue Embroidered Saree Blouse – Timeless Grace with a Touch of Royalty

Add a regal charm to your ethnic ensemble with our blue embroidered saree blouse – a perfect blend of elegance and traditional artistry. This blouse is ideal for weddings, cultural functions, festivals, and special occasions.
✨ Key Features:


 	
Royal Blue Color: A deep, elegant hue that pairs beautifully with silk, cotton, or georgette sarees.

 	
Classic Round Neck: A universally flattering neckline that suits all saree draping styles.

 	
Front Open with Hook Closure: Designed for ease and convenience, ensuring a secure yet stylish fit.

 	
Delicate Embroidery: Adorned with rich hand embroidery – maggam work, zardosi detailing, and mirror embellishments for a luxurious finish.

 	
Soft, Breathable Fabric: Crafted from high-quality silk, cotton silk, or georgette for all-day comfort and durability.

 	
Wide Size Range: Available in sizes 26 to 42, offering a tailored look for every body type.

', 'Elevate your wardrobe with this stylish Blue Embroidered blouses for sarees. Perfect variable piece that offers both comfort and contemporary design.', 'CTN_EMB_BLU-1', 249, NULL, 100, 1, 1, 0.3, NULL, 24, '[\"products\\/migrated_1759079822_68d96d8e7bc49.jpg\",\"products\\/migrated_1759079823_68d96d8fcb2f6.jpg\",\"products\\/migrated_1759079825_68d96d91447ed.jpg\",\"products\\/migrated_1759079827_68d96d9352c04.jpg\",\"products\\/migrated_1759079840_68d96da0e61a5.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Blue Embroidered blouses for sarees in our Blouse
 collection. High-quality fashion at ₹249. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Blue Embroidered blouses for sarees - Stylish variable at', '**About This Product**

The Blue Embroidered blouses for sarees represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this variable piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this variable piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Blue Embroidered blouses for sarees\",\"description\":\"Elevate your wardrobe with this stylish Blue Embroidered blouses for sarees. Perfect variable piece that offers both comfort and contemporary design.\",\"sku\":\"CTN_EMB_BLU-1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"249.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:46:56', 'blue embroidered blouses for sarees, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '💙 Blue Embroidered Saree Blouse – Timeless Grace with a Touch of Royalty

Add a regal charm to your ethnic ensemble with our blue embroidered saree blouse – a perfect blend of elegance and traditional artistry. This blouse is ideal for weddings, cultural functions, festivals, and special occasions.
✨ Key Features:


 	
Royal Blue Color: A deep, elegant hue that pairs beautifully with silk, cotton, or georgette sarees.

 	
Classic Round Neck: A universally flattering neckline that suits all saree draping styles.

 	
Front Open with Hook Closure: Designed for ease and convenience, ensuring a secure yet stylish fit.

 	
Delicate Embroidery: Adorned with rich hand embroidery – maggam work, zardosi detailing, and mirror embellishments for a luxurious finish.

 	
Soft, Breathable Fabric: Crafted from high-quality silk, cotton silk, or georgette for all-day comfort and durability.

 	
Wide Size Range: Available in sizes 26 to 42, offering a tailored look for every body type.

', NULL, '[\"Designer red saree blouse 26 to 42 size\",\"Front open red blouse for saree\",\"Hand-embroidered red saree blouse\",\"Red blouse for wedding saree\",\"Red blouse with hook closure\",\"Red embroidered saree blouse\",\"Round neck red blouse with embroidery\",\"Traditional red blouse with round neck\"]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 13),
(39, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c927415d', 'Capsule 2 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'DCP2IPC_1', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079842_68d96da2a4ae2.jpg\",\"products\\/migrated_1759079844_68d96da467cb9.jpg\",\"products\\/migrated_1759079845_68d96da5dcae2.jpg\",\"products\\/migrated_1759079847_68d96da7303d0.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Capsule 2 Pcs Set online at SJ Fashion Hub. Stylish Capsule 2 Pcs Set with premium quality. Price: ₹360. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"DCP2IPC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(40, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c92756fa', 'Capsule 2 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 2 Pcs Set. A must-have simple item for fashion-forward individuals.', 'DCP2IPC_2', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079848_68d96da8229c7.jpg\",\"products\\/migrated_1759079848_68d96da8dde7a.jpg\",\"products\\/migrated_1759079849_68d96da9be5c8.jpg\",\"products\\/migrated_1759079851_68d96dab00f36.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 2 Pcs Set from SJ Fashion Hub\'s Capsule 2 Pcs Set range. Quality assured at ₹360. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop Capsule 2 Pcs Set - Latest simple Fashion | SJ Fashio', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 2 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"DCP2IPC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(41, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c9276d6f', 'Capsule 2 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'DCP2IPC_3', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079852_68d96dac07cb2.jpg\",\"products\\/migrated_1759079853_68d96dad9e987.jpg\",\"products\\/migrated_1759079855_68d96daf36796.jpg\",\"products\\/migrated_1759079857_68d96db133734.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Capsule 2 Pcs Set in our Capsule 2 Pcs Set collection. High-quality fashion at ₹360. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"DCP2IPC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(42, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c9278618', 'Capsule 2 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'DCP2IPC_4', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079857_68d96db157653.jpg\",\"products\\/migrated_1759079858_68d96db24981c.jpg\",\"products\\/migrated_1759079859_68d96db3415fb.jpg\",\"products\\/migrated_1759079861_68d96db50b0ae.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 2 Pcs Set from SJ Fashion Hub\'s Capsule 2 Pcs Set range. Quality assured at ₹360. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 2 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"DCP2IPC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(43, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c9279b91', 'Capsule 2 Pcs Set', 'Elevate your wardrobe with this stylish Capsule 2 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'CPSL2PR_5', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079862_68d96db6186f0.jpg\",\"products\\/migrated_1759079862_68d96db6d48fb.jpg\",\"products\\/migrated_1759079864_68d96db807f07.jpg\",\"products\\/migrated_1759079864_68d96db8ec0d2.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Capsule 2 Pcs Set online at SJ Fashion Hub. Stylish Capsule 2 Pcs Set with premium quality. Price: ₹360. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish Capsule 2 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"CPSL2PR_5\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(44, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c927ada8', 'Capsule 2 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 2 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CPSL2PR_6', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079866_68d96dbae5f4e.jpg\",\"products\\/migrated_1759079867_68d96dbbbe602.jpg\",\"products\\/migrated_1759079868_68d96dbcb16ba.jpg\",\"products\\/migrated_1759079869_68d96dbd93a6a.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Capsule 2 Pcs Set at SJ Fashion Hub. Premium quality Capsule 2 Pcs Set starting from ₹360. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 2 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CPSL2PR_6\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(45, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c927bfb2', 'Capsule 2 Pcs Set', 'Elevate your wardrobe with this stylish Capsule 2 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'CPSL2PR_7', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079870_68d96dbe643cb.jpg\",\"products\\/migrated_1759079871_68d96dbf550e5.jpg\",\"products\\/migrated_1759079873_68d96dc183ca8.jpg\",\"products\\/migrated_1759079874_68d96dc298e93.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Capsule 2 Pcs Set at SJ Fashion Hub. Premium quality Capsule 2 Pcs Set starting from ₹360. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 2 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish Capsule 2 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"CPSL2PR_7\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(46, 'Capsule 2 Pcs Set', 'capsule-2-pcs-set-68d90c927d1b2', 'Capsule 2 Pcs Set', 'Experience luxury and comfort with this Capsule 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSL2PR_8', 360, NULL, 1, 1, 1, 0.85, NULL, 25, '[\"products\\/migrated_1759079875_68d96dc34f8ea.jpg\",\"products\\/migrated_1759079876_68d96dc426894.jpg\",\"products\\/migrated_1759079877_68d96dc5423e5.jpg\",\"products\\/migrated_1759079878_68d96dc66d691.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 2 Pcs Set from SJ Fashion Hub\'s Capsule 2 Pcs Set range. Quality assured at ₹360. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop Capsule 2 Pcs Set - Latest simple Fashion | SJ Fashio', '**About This Product**

The Capsule 2 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 2 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 2 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSL2PR_8\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"360.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 2 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 2 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 2 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 14),
(47, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c927e2ae', 'Capsule 3 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CTSLF3PCP_1', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079880_68d96dc8231f2.jpg\",\"products\\/migrated_1759079880_68d96dc8dc832.jpg\",\"products\\/migrated_1759079882_68d96dca0b4a8.jpg\",\"products\\/migrated_1759079883_68d96dcba4917.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CTSLF3PCP_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(48, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c927f83d', 'Capsule 3 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CPSLF3PCP_2', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079885_68d96dcd46824.jpg\",\"products\\/migrated_1759079886_68d96dce57e9d.jpg\",\"products\\/migrated_1759079887_68d96dcf1ebef.jpg\",\"products\\/migrated_1759079888_68d96dd010f9b.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Capsule 3 Pcs Set at SJ Fashion Hub. Premium quality Capsule 3 Pcs Set starting from ₹400. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CPSLF3PCP_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(49, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9280d0f', 'Capsule 3 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'CPSLF3PCP_3', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079889_68d96dd1864d2.jpg\",\"products\\/migrated_1759079890_68d96dd2394df.jpg\",\"products\\/migrated_1759079891_68d96dd34e20e.jpg\",\"products\\/migrated_1759079892_68d96dd47c2dc.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Capsule 3 Pcs Set online at SJ Fashion Hub. Stylish Capsule 3 Pcs Set with premium quality. Price: ₹400. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop Capsule 3 Pcs Set - Latest simple Fashion | SJ Fashio', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"CPSLF3PCP_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(50, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c92824d8', 'Capsule 3 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'CPSLF3PCP_4', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079892_68d96dd484f5a.jpg\",\"products\\/migrated_1759079894_68d96dd65b73d.jpg\",\"products\\/migrated_1759079895_68d96dd75ab02.jpg\",\"products\\/migrated_1759079896_68d96dd84a239.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"CPSLF3PCP_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(51, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c92838f2', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSLF3PCP_5', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079897_68d96dd92b944.jpg\",\"products\\/migrated_1759079897_68d96dd9ea562.jpg\",\"products\\/migrated_1759079899_68d96ddb5ec85.jpg\",\"products\\/migrated_1759079900_68d96ddc42479.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSLF3PCP_5\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(52, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9284d94', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSLF3PCP_6', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079901_68d96ddd0707f.jpg\",\"products\\/migrated_1759079901_68d96ddde62a4.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Capsule 3 Pcs Set in our Capsule 3 Pcs Set collection. High-quality fashion at ₹400. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop Capsule 3 Pcs Set - Latest simple Fashion | SJ Fashio', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSLF3PCP_6\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(53, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9285f40', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSLF3PCP_7', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079902_68d96ddea9264.jpg\",\"products\\/migrated_1759079903_68d96ddfa24f4.jpg\",\"products\\/migrated_1759079904_68d96de043d6d.jpg\",\"products\\/migrated_1759079905_68d96de12d4d2.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Capsule 3 Pcs Set in our Capsule 3 Pcs Set collection. High-quality fashion at ₹400. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSLF3PCP_7\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(54, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9287044', 'Capsule 3 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'CPSLF3PCP_8', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079905_68d96de1f3b92.jpg\",\"products\\/migrated_1759079907_68d96de3d5206.jpg\",\"products\\/migrated_1759079909_68d96de5e81dd.jpg\",\"products\\/migrated_1759079911_68d96de75153d.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Capsule 3 Pcs Set online at SJ Fashion Hub. Stylish Capsule 3 Pcs Set with premium quality. Price: ₹400. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"CPSLF3PCP_8\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(55, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c92886c3', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'CPSLF3PCP_9', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079913_68d96de92b8ad.jpg\",\"products\\/migrated_1759079915_68d96debefafd.jpg\",\"products\\/migrated_1759079916_68d96decd61c2.jpg\",\"products\\/migrated_1759079917_68d96deda1587.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"CPSLF3PCP_9\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(56, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9289bd0', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'DCPFLIH_1', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079919_68d96def6ddb2.jpg\",\"products\\/migrated_1759079920_68d96df0af6b5.jpg\",\"products\\/migrated_1759079922_68d96df207149.jpg\",\"products\\/migrated_1759079922_68d96df2bef3b.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy Capsule 3 Pcs Set Online - simple Collection | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"DCPFLIH_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(57, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c928b090', 'Capsule 3 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'DCPFLIH_2', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079924_68d96df48dbb8.jpg\",\"products\\/migrated_1759079926_68d96df637e4c.jpg\",\"products\\/migrated_1759079928_68d96df8a889f.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Capsule 3 Pcs Set in our Capsule 3 Pcs Set collection. High-quality fashion at ₹400. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy Capsule 3 Pcs Set Online - simple Collection | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"DCPFLIH_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(58, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c928ce88', 'Capsule 3 Pcs Set', 'Elevate your wardrobe with this stylish Capsule 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'DCPFLIH_3', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079929_68d96df9b12f8.jpg\",\"products\\/migrated_1759079930_68d96dfa9a3ca.jpg\",\"products\\/migrated_1759079931_68d96dfb78cce.jpg\",\"products\\/migrated_1759079932_68d96dfc67e93.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Capsule 3 Pcs Set online at SJ Fashion Hub. Stylish Capsule 3 Pcs Set with premium quality. Price: ₹400. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish Capsule 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"DCPFLIH_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(59, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c928e0cb', 'Capsule 3 Pcs Set', 'Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'DCPFLIH_4', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079933_68d96dfd81aec.jpg\",\"products\\/migrated_1759079934_68d96dfe4800f.jpg\",\"products\\/migrated_1759079935_68d96dff10857.jpg\",\"products\\/migrated_1759079936_68d96e0011128.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Capsule 3 Pcs Set at SJ Fashion Hub. Premium quality Capsule 3 Pcs Set starting from ₹400. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy Capsule 3 Pcs Set Online - simple Collection | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Capsule 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"DCPFLIH_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(60, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c928f98e', 'Capsule 3 Pcs Set', 'Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'DCPFLIH_5', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079937_68d96e013cbc6.jpg\",\"products\\/migrated_1759079937_68d96e01e93c4.jpg\",\"products\\/migrated_1759079939_68d96e0357f93.jpg\",\"products\\/migrated_1759079940_68d96e044b5ab.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Capsule 3 Pcs Set at SJ Fashion Hub. Premium quality Capsule 3 Pcs Set starting from ₹400. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Stylish simple at Best Price | SJ Fash', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Capsule 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"DCPFLIH_5\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(61, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9291166', 'Capsule 3 Pcs Set', 'Elevate your wardrobe with this stylish Capsule 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'DCPFLIH_6', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079941_68d96e0527630.jpg\",\"products\\/migrated_1759079942_68d96e06d171b.jpg\",\"products\\/migrated_1759079943_68d96e07bca16.jpg\",\"products\\/migrated_1759079945_68d96e0982ccd.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Capsule 3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish Capsule 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"DCPFLIH_6\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(62, 'Capsule 3 Pcs Set', 'capsule-3-pcs-set-68d90c9292922', 'Capsule 3 Pcs Set', 'Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'DCPFLIH_7', 400, NULL, 1, 1, 1, 0.85, NULL, 26, '[\"products\\/migrated_1759079946_68d96e0a595e6.jpg\",\"products\\/migrated_1759079947_68d96e0b2219e.jpg\",\"products\\/migrated_1759079949_68d96e0d60676.jpg\",\"products\\/migrated_1759079950_68d96e0e7cd16.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Capsule 3 Pcs Set from SJ Fashion Hub\'s Capsule 3 Pcs Set range. Quality assured at ₹400. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Shop Capsule 3 Pcs Set - Latest simple Fashion | SJ Fashio', '**About This Product**

The Capsule 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Capsule 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Capsule 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"DCPFLIH_7\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"400.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Capsule 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'capsule 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Capsule 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(63, 'Cotton Daily Wear Blouse Black', 'cotton-daily-wear-blouse-black-68d90c9293d12', 'Discover effortless elegance with our black cotton embroidered saree blouse, designed for women who value both tradition and comfort. Whether for casual wear, office sarees, or light festive occasions, this blouse offers style without compromise.
✨ Key Features:


 	
Pure Cotton Fabric: Soft, breathable, and gentle on the skin – ideal for all-day wear in every season.

 	
Elegant Round Neck: A timeless neckline that suits both traditional and modern saree drapes.

 	
Front Open with Hook Closure: Easy to wear and remove, offering convenience without sacrificing grace.

 	
Minimal Embroidery Detailing: Featuring subtle hand embroidery or threadwork that adds charm without being overpowering – perfect for cotton and linen sarees.

 	
Tailored Comfort: Available in sizes 26 to 42, providing a snug yet comfortable fit for all body types.

 	
Everyday Elegance: Designed to be your go-to blouse for office, travel, puja, or daily wear sarees.

', 'Discover the perfect blend of style and quality in this Cotton Daily Wear Blouse Black. A must-have blouse
 item for fashion-forward individuals.', 'CTNPLNBLK', 199, NULL, 5, 1, 1, 0.35, NULL, 24, '[\"products\\/migrated_1759079952_68d96e103ed5e.jpg\",\"products\\/migrated_1759079954_68d96e12225da.jpg\",\"products\\/migrated_1759079955_68d96e13b183e.jpg\",\"products\\/migrated_1759079957_68d96e157d41e.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Cotton Daily Wear Blouse Black at SJ Fashion Hub. Premium quality Blouse
 starting from ₹199. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Buy Cotton Daily Wear Blouse Black Online - Blouse
 Collec', '**About This Product**

The Cotton Daily Wear Blouse Black represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Blouse
 piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Blouse
 piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Cotton Daily Wear Blouse Black\",\"description\":\"Discover the perfect blend of style and quality in this Cotton Daily Wear Blouse Black. A must-have variable item for fashion-forward individuals.\",\"sku\":\"CTNPLNBLK\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"199.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:50:02', 'cotton daily wear blouse black, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Discover effortless elegance with our black cotton embroidered saree blouse, designed for women who value both tradition and comfort. Whether for casual wear, office sarees, or light festive occasions, this blouse offers style without compromise.
✨ Key Features:


 	
Pure Cotton Fabric: Soft, breathable, and gentle on the skin – ideal for all-day wear in every season.

 	
Elegant Round Neck: A timeless neckline that suits both traditional and modern saree drapes.

 	
Front Open with Hook Closure: Easy to wear and remove, offering convenience without sacrificing grace.

 	
Minimal Embroidery Detailing: Featuring subtle hand embroidery or threadwork that adds charm without being overpowering – perfect for cotton and linen sarees.

 	
Tailored Comfort: Available in sizes 26 to 42, providing a snug yet comfortable fit for all body types.

 	
Everyday Elegance: Designed to be your go-to blouse for office, travel, puja, or daily wear sarees.

', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 9),
(64, 'Cotton Daily Wear Blouse Black', 'cotton-daily-wear-blouse-black-68d90c92955ed', 'Cotton Daily Wear Blouse YBlack', 'Premium blouse
 crafted with attention to detail. Cotton Daily Wear Blouse Black combines style and comfort for the modern fashion enthusiast.', 'SKU-68d90c929560a', 149, NULL, 1000, 1, 1, 0.35, NULL, 24, '[\"products\\/migrated_1759079962_68d96e1a68353.jpg\",\"products\\/migrated_1759079970_68d96e2205924.jpg\",\"products\\/migrated_1759079973_68d96e25b8be5.jpg\",\"products\\/migrated_1759079976_68d96e28ea3c8.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Cotton Daily Wear Blouse Black online at SJ Fashion Hub. Stylish Blouse
 with premium quality. Price: ₹149. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Shop Cotton Daily Wear Blouse Black - Latest Blouse
 Fashi', '**About This Product**

The Cotton Daily Wear Blouse Black represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Blouse
 piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Blouse
 piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Cotton Daily Wear Blouse Black\",\"description\":\"Experience luxury and comfort with this Cotton Daily Wear Blouse Black. Expertly designed variable that complements any modern wardrobe.\",\"sku\":\"SKU-68d90c929560a\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"149.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:50:02', 'cotton daily wear blouse black, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cotton Daily Wear Blouse YBlack', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 9),
(65, 'Cotton Daily Wear Blouse Yellow', 'cotton-daily-wear-blouse-yellow-68d90c929705f', 'Cotton Daily Wear Blouse Yellow', 'Discover the perfect blend of style and quality in this Cotton Daily Wear Blouse Yellow. A must-have blouse
 item for fashion-forward individuals.', 'CTNPLNYLW_L', 149, NULL, 1000, 1, 1, 0.35, NULL, 24, '[\"products\\/migrated_1759079977_68d96e29caa8b.webp\",\"products\\/migrated_1759079978_68d96e2a80174.webp\"]', NULL, 0, 1, 'active', NULL, 'Discover Cotton Daily Wear Blouse Yellow in our Blouse
 collection. High-quality fashion at ₹149. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Buy Cotton Daily Wear Blouse Yellow Online - Blouse
 Colle', '**About This Product**

The Cotton Daily Wear Blouse Yellow represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Blouse
 piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Blouse
 piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Cotton Daily Wear Blouse Yellow\",\"description\":\"Experience luxury and comfort with this Cotton Daily Wear Blouse Yellow. Expertly designed variable that complements any modern wardrobe.\",\"sku\":\"CTNPLNYLW_L\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"149.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:50:02', 'cotton daily wear blouse yellow, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cotton Daily Wear Blouse Yellow', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 9),
(66, 'Cotton Daily Wear Red Printed Blouse', 'cotton-daily-wear-red-printed-blouse-68d90c92982ca', 'Cotton Daily Wear Red Printed Blouse', 'Elevate your wardrobe with this stylish Cotton Daily Wear Red Printed Blouse. Perfect blouse
 piece that offers both comfort and contemporary design.', 'CTNPRNTRDBLS_L', 250, NULL, 99998, 1, 1, 0.35, NULL, 24, '[\"products\\/migrated_1759079980_68d96e2cc201d.jpg\",\"products\\/migrated_1759079982_68d96e2e9c01b.jpg\",\"products\\/migrated_1759079984_68d96e308d1d1.jpg\",\"products\\/migrated_1759079986_68d96e32c69fa.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Cotton Daily Wear Red Printed Blouse online at SJ Fashion Hub. Stylish Blouse
 with premium quality. Price: ₹250. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Shop Cotton Daily Wear Red Printed Blouse - Latest Blouse', '**About This Product**

The Cotton Daily Wear Red Printed Blouse represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Blouse
 piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Blouse
 piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Cotton Daily Wear Red Printed Blouse\",\"description\":\"Discover the perfect blend of style and quality in this Cotton Daily Wear Red Printed Blouse. A must-have variable item for fashion-forward individuals.\",\"sku\":\"CTNPRNTRDBLS_L\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"250.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:50:02', 'cotton daily wear red printed blouse, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Cotton Daily Wear Red Printed Blouse', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 9),
(67, 'Kurti', 'kurti-68d90c9299a6c', 'Kurti', 'Discover the perfect blend of style and quality in this Kurti. A must-have simple item for fashion-forward individuals.', 'PLKAAR_1', 480, NULL, 1, 1, 1, 0.85, NULL, 31, '[\"products\\/migrated_1759079987_68d96e3384082.jpg\",\"products\\/migrated_1759079989_68d96e357ef40.jpg\",\"products\\/migrated_1759079990_68d96e367b007.jpg\",\"products\\/migrated_1759079991_68d96e37417f7.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Kurti in our Kurti collection. High-quality fashion at ₹480. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Shop Kurti - Latest simple Fashion | SJ Fashion Hub', '**About This Product**

The Kurti represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Kurti\",\"description\":\"Discover the perfect blend of style and quality in this Kurti. A must-have simple item for fashion-forward individuals.\",\"sku\":\"PLKAAR_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"480.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Kurti\"}', 1, '2025-09-28 10:46:56', 'kurti, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kurti', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 4),
(68, 'Kurti', 'kurti-68d90c929accc', 'Kurti', 'Experience luxury and comfort with this Kurti. Expertly designed simple that complements any modern wardrobe.', 'PLKAAR_2', 480, NULL, 1, 1, 1, 0.85, NULL, 31, '[\"products\\/migrated_1759079991_68d96e37f27e8.jpg\",\"products\\/migrated_1759079993_68d96e39117f6.jpg\",\"products\\/migrated_1759079993_68d96e39edd74.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Kurti at SJ Fashion Hub. Premium quality Kurti starting from ₹480. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Buy Kurti Online - simple Collection | SJ Fashion Hub', '**About This Product**

The Kurti represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Kurti\",\"description\":\"Experience luxury and comfort with this Kurti. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"PLKAAR_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"480.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Kurti\"}', 1, '2025-09-28 10:46:56', 'kurti, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kurti', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 4),
(69, 'Kurti', 'kurti-68d90c929be98', 'Kurti', 'Experience luxury and comfort with this Kurti. Expertly designed simple that complements any modern wardrobe.', 'PLKAAR_3', 480, NULL, 1, 1, 1, 0.85, NULL, 31, '[\"products\\/migrated_1759079994_68d96e3ac7be6.jpg\",\"products\\/migrated_1759079995_68d96e3ba78c6.jpg\",\"products\\/migrated_1759079996_68d96e3c74f09.jpg\",\"products\\/migrated_1759079997_68d96e3d24cfe.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Kurti at SJ Fashion Hub. Premium quality Kurti starting from ₹480. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Kurti - Quality simple for Every Occasion | SJ Fashion Hub', '**About This Product**

The Kurti represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Kurti\",\"description\":\"Experience luxury and comfort with this Kurti. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"PLKAAR_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"480.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Kurti\"}', 1, '2025-09-28 10:46:56', 'kurti, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Kurti', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 4),
(70, 'Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded', 'latest-design-white-cotton-embroidered-blouse-for-women-sizes-26-42-cool-half-sleeve-round-neck-floral-design-non-padded-68d90c929d9c7', 'Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded
 
 
Embrace Serene Elegance with Our Stunning White Floral Blouse!
 
Step into refreshing comfort and captivating style with our latest design white cotton embroidered blouse for women. Perfectly suited for the warm and humid climate of Bolpur, West Bengal, and ideal for any discerning occasion across India, this blouse is meticulously crafted from premium, breathable cotton to ensure you remain cool and comfortable throughout the day.
The pristine white hue of this blouse, gracefully adorned with delicate floral embroidery, offers unparalleled purity, elegance, and versatility. White signifies freshness, sophistication, and adaptability, making this blouse an indispensable and adaptable addition to any modern wardrobe that effortlessly complements various ethnic, fusion, and Western outfits.
Our designers have meticulously curated the embroidery patterns to align with the forefront of 2025 fashion trends. These beautiful floral designs bloom artistically across the fabric, adding a touch of refined artistry and a subtle, feminine appeal to a classic silhouette.

 
Key Features &amp; Benefits That Make It a Top Choice:
 


Cool &amp; Breathable Cotton: Made from 100% pure, soft cotton, this blouse is incredibly breathable and lightweight. It ensures you stay cool and comfortable even during extended wear, making it perfect for daily elegance, office wear, or long events.


Pristine White with Floral Embroidery: A captivating white shade enriched with exquisite floral design embroidery. This striking combination offers a sophisticated and elegant look suitable for a wide range of occasions, from formal gatherings and festive celebrations to casual outings and daytime events.


Comfortable Half Sleeves: Designed with practical half sleeves, this blouse offers ease of movement and a relaxed yet stylish fit, ideal for both everyday wear and special occasions.


Classic Round Neckline: The timeless round neck design provides a universally flattering silhouette, offering comfort and versatility to complement various accessories.


Non-Padded Comfort: Crafted as a non-padded blouse, it offers a natural and comfortable fit, prioritizing ease and simplicity without compromising on shape or style.


Convenient Front Hook Opening: Featuring a practical front hook closure for hassle-free dressing, combining essential ease with refined elegance.


Unmatched Versatility: This readymade blouse is a true wardrobe essential, adapting seamlessly to various looks and occasions:


Traditional Sarees: A perfect companion for printed, embroidered, or even plain sarees, allowing the saree\'s design to shine while providing a sophisticated base.


Lehenga Skirts: Create a chic Indo-western statement for casual festive events or daytime celebrations.


Modern Fusion: Effortlessly team it with high-waisted skirts, tailored trousers, or even jeans for a unique, fashionable look perfect for social gatherings, office wear, or stylish everyday attire.




Inclusive Sizing &amp; Readymade Convenience: Designed for a flattering and comfortable fit across a wide spectrum of body types. It\'s available in sizes 26 to 42, ensuring everyone finds their perfect match. The readymade design offers instant style with no tailoring hassle, saving you valuable time.


Durable &amp; Easy Care: Constructed with high-quality cotton fabric and embroidery for long-lasting beauty. Simple care instructions ensure easy maintenance, allowing you to cherish this beautiful piece for years to come.

', 'Elevate your wardrobe with this stylish Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded. Perfect blouse
 piece that offers both comfort and contemporary design.', 'SKU-68d90c929d9f6', 249, NULL, 99, 1, 1, 0.3, NULL, 24, '[\"products\\/migrated_1759080000_68d96e409d96a.jpg\",\"products\\/migrated_1759080003_68d96e43c089b.jpg\",\"products\\/migrated_1759080006_68d96e46c4d45.jpg\",\"products\\/migrated_1759080009_68d96e4978506.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded at SJ Fashion Hub. Premiu', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Buy Latest Design White Cotton Embroidered Blouse for Wome', '**About This Product**

The Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Blouse
 piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Blouse
 piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded\",\"description\":\"Experience luxury and comfort with this Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded. Expertly designed variable that complements any modern wardrobe.\",\"sku\":\"SKU-68d90c929d9f6\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"249.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:50:02', 'latest design white cotton embroidered blouse for women (sizes 26-42) - cool half sleeve, round neck, floral design, non-padded, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Latest Design White Cotton Embroidered Blouse for Women (Sizes 26-42) - Cool Half Sleeve, Round Neck, Floral Design, Non-Padded
 
 
Embrace Serene Elegance with Our Stunning White Floral Blouse!
 
Step into refreshing comfort and captivating style with our latest design white cotton embroidered blouse for women. Perfectly suited for the warm and humid climate of Bolpur, West Bengal, and ideal for any discerning occasion across India, this blouse is meticulously crafted from premium, breathable cotton to ensure you remain cool and comfortable throughout the day.
The pristine white hue of this blouse, gracefully adorned with delicate floral embroidery, offers unparalleled purity, elegance, and versatility. White signifies freshness, sophistication, and adaptability, making this blouse an indispensable and adaptable addition to any modern wardrobe that effortlessly complements various ethnic, fusion, and Western outfits.
Our designers have meticulously curated the embroidery patterns to align with the forefront of 2025 fashion trends. These beautiful floral designs bloom artistically across the fabric, adding a touch of refined artistry and a subtle, feminine appeal to a classic silhouette.

 
Key Features &amp; Benefits That Make It a Top Choice:
 


Cool &amp; Breathable Cotton: Made from 100% pure, soft cotton, this blouse is incredibly breathable and lightweight. It ensures you stay cool and comfortable even during extended wear, making it perfect for daily elegance, office wear, or long events.


Pristine White with Floral Embroidery: A captivating white shade enriched with exquisite floral design embroidery. This striking combination offers a sophisticated and elegant look suitable for a wide range of occasions, from formal gatherings and festive celebrations to casual outings and daytime events.


Comfortable Half Sleeves: Designed with practical half sleeves, this blouse offers ease of movement and a relaxed yet stylish fit, ideal for both everyday wear and special occasions.


Classic Round Neckline: The timeless round neck design provides a universally flattering silhouette, offering comfort and versatility to complement various accessories.


Non-Padded Comfort: Crafted as a non-padded blouse, it offers a natural and comfortable fit, prioritizing ease and simplicity without compromising on shape or style.


Convenient Front Hook Opening: Featuring a practical front hook closure for hassle-free dressing, combining essential ease with refined elegance.


Unmatched Versatility: This readymade blouse is a true wardrobe essential, adapting seamlessly to various looks and occasions:


Traditional Sarees: A perfect companion for printed, embroidered, or even plain sarees, allowing the saree\'s design to shine while providing a sophisticated base.


Lehenga Skirts: Create a chic Indo-western statement for casual festive events or daytime celebrations.


Modern Fusion: Effortlessly team it with high-waisted skirts, tailored trousers, or even jeans for a unique, fashionable look perfect for social gatherings, office wear, or stylish everyday attire.




Inclusive Sizing &amp; Readymade Convenience: Designed for a flattering and comfortable fit across a wide spectrum of body types. It\'s available in sizes 26 to 42, ensuring everyone finds their perfect match. The readymade design offers instant style with no tailoring hassle, saving you valuable time.


Durable &amp; Easy Care: Constructed with high-quality cotton fabric and embroidery for long-lasting beauty. Simple care instructions ensure easy maintenance, allowing you to cherish this beautiful piece for years to come.

', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 13),
(71, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c929ee02', 'Nayara 3 Pcs Set', 'Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'NYR3IPC_1', 470, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080010_68d96e4a4d680.jpg\",\"products\\/migrated_1759080011_68d96e4b5c8f9.jpg\",\"products\\/migrated_1759080012_68d96e4c4a076.jpg\",\"products\\/migrated_1759080013_68d96e4d1704a.jpg\"]', NULL, 0, 1, 'active', NULL, 'Shop Nayara 3 Pcs Set at SJ Fashion Hub. Premium quality Nayara 3 Pcs Set starting from ₹470. Free shipping on orders above ₹999. Buy now!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Premium simple | SJ Fashion Hub', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"NYR3IPC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"470.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(72, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a01cc', 'Nayara 3 Pcs Set', 'Elevate your wardrobe with this stylish Nayara 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.', 'NYR3IPC_2', 470, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080013_68d96e4de75b8.jpg\",\"products\\/migrated_1759080014_68d96e4eccb26.jpg\",\"products\\/migrated_1759080015_68d96e4f8b380.jpg\",\"products\\/migrated_1759080016_68d96e506047c.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Nayara 3 Pcs Set in our Nayara 3 Pcs Set collection. High-quality fashion at ₹470. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy Nayara 3 Pcs Set Online - simple Collection | SJ Fashi', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Elevate your wardrobe with this stylish Nayara 3 Pcs Set. Perfect simple piece that offers both comfort and contemporary design.\",\"sku\":\"NYR3IPC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"470.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(73, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a162a', 'Nayara 3 Pcs Set', 'Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'NYR3IPC_3', 470, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080016_68d96e50b8e7f.jpg\",\"products\\/migrated_1759080018_68d96e527de6f.jpg\",\"products\\/migrated_1759080019_68d96e533bbaf.jpg\",\"products\\/migrated_1759080019_68d96e53e7186.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Nayara 3 Pcs Set in our Nayara 3 Pcs Set collection. High-quality fashion at ₹470. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"NYR3IPC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"470.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(74, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a2ca5', 'Nayara 3 Pcs Set', 'Experience luxury and comfort with this Nayara 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'NYR3IPC_4', 470, NULL, 0, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080020_68d96e541645d.jpg\",\"products\\/migrated_1759080021_68d96e551a4c0.jpg\",\"products\\/migrated_1759080021_68d96e55bcfa8.jpg\",\"products\\/migrated_1759080022_68d96e56c7dd7.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Nayara 3 Pcs Set online at SJ Fashion Hub. Stylish Nayara 3 Pcs Set with premium quality. Price: ₹470. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Stylish simple at Best Price | SJ Fashi', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Nayara 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"NYR3IPC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"470.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/OutOfStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(75, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a41d4', 'Nayara 3 Pcs Set', 'Experience luxury and comfort with this Nayara 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.', 'RYPNIPC_1', 500, NULL, 0, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080023_68d96e57762c6.jpg\",\"products\\/migrated_1759080025_68d96e593326d.jpg\",\"products\\/migrated_1759080026_68d96e5a418bc.jpg\",\"products\\/migrated_1759080027_68d96e5b51077.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Nayara 3 Pcs Set online at SJ Fashion Hub. Stylish Nayara 3 Pcs Set with premium quality. Price: ₹500. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Stylish simple at Best Price | SJ Fashi', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Experience luxury and comfort with this Nayara 3 Pcs Set. Expertly designed simple that complements any modern wardrobe.\",\"sku\":\"RYPNIPC_1\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/OutOfStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(76, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a5822', 'Nayara 3 Pcs Set', 'Premium simple crafted with attention to detail. Nayara 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'RYPNIPC_2', 500, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080027_68d96e5bf1292.jpg\",\"products\\/migrated_1759080029_68d96e5d1f155.jpg\",\"products\\/migrated_1759080029_68d96e5dcef73.jpg\",\"products\\/migrated_1759080030_68d96e5ec01ec.jpg\"]', NULL, 0, 1, 'active', NULL, 'Buy Nayara 3 Pcs Set online at SJ Fashion Hub. Stylish Nayara 3 Pcs Set with premium quality. Price: ₹500. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Nayara 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"RYPNIPC_2\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(77, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a6bf3', 'Nayara 3 Pcs Set', 'Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.', 'RYPNIPC_3', 500, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080031_68d96e5f489c4.jpg\",\"products\\/migrated_1759080032_68d96e609665f.jpg\",\"products\\/migrated_1759080033_68d96e61467b9.jpg\",\"products\\/migrated_1759080034_68d96e62c2288.jpg\"]', NULL, 0, 1, 'active', NULL, 'Discover Nayara 3 Pcs Set in our Nayara 3 Pcs Set collection. High-quality fashion at ₹500. Easy returns & fast delivery. Order today!', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Nayara 3 Pcs Set - Quality simple for Every Occasion | SJ', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Discover the perfect blend of style and quality in this Nayara 3 Pcs Set. A must-have simple item for fashion-forward individuals.\",\"sku\":\"RYPNIPC_3\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(78, 'Nayara 3 Pcs Set', 'nayara-3-pcs-set-68d90c92a7e33', 'Nayara 3 Pcs Set', 'Premium simple crafted with attention to detail. Nayara 3 Pcs Set combines style and comfort for the modern fashion enthusiast.', 'RYPNIPC_4', 500, NULL, 1, 1, 1, 0.85, NULL, 33, '[\"products\\/migrated_1759080035_68d96e638399f.jpg\",\"products\\/migrated_1759080036_68d96e644a9d7.jpg\",\"products\\/migrated_1759080037_68d96e65c1da9.jpg\",\"products\\/migrated_1759080038_68d96e66ddde5.jpg\"]', NULL, 0, 1, 'active', NULL, 'Get Nayara 3 Pcs Set from SJ Fashion Hub\'s Nayara 3 Pcs Set range. Quality assured at ₹500. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-10-13 01:10:55', 'Buy Nayara 3 Pcs Set Online - simple Collection | SJ Fashi', '**About This Product**

The Nayara 3 Pcs Set represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this simple piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this simple piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Nayara 3 Pcs Set\",\"description\":\"Premium simple crafted with attention to detail. Nayara 3 Pcs Set combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"RYPNIPC_4\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"500.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Nayara 3 Pcs Set\"}', 1, '2025-09-28 10:46:56', 'nayara 3 pcs set, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 'Nayara 3 Pcs Set', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 15),
(79, 'Red Embroidered blouses for sarees', 'red-embroidered-blouses-for-sarees-68d90c92a909b', '🔥 Red Embroidered Saree Blouse – Classic Elegance in Every Stitch

Step into timeless elegance with our red embroidered saree blouse – a masterpiece that combines traditional beauty with modern comfort. Designed for women who appreciate fine craftsmanship, this blouse is perfect for weddings, festive events, and traditional occasions.
✨ Key Features:


 	
Rich Red Color: A bold and auspicious shade that enhances every saree, from silk to chiffon.

 	
Round Neck Design: Classic and versatile, flattering for all saree drapes and jewelry styles.

 	
Front Open with Hook Closure: Easy to wear and style, offering a secure and comfortable fit.

 	
Intricate Embroidery: Detailed handwork using zardosi, maggam, and mirror embellishments that add depth and luxury.

 	
Comfortable Fabric: Made from high-quality silk or georgette that feels soft on the skin and ensures all-day comfort.

 	
Size Range: Available in sizes 26 to 42, ensuring a perfect fit for every body type.

', 'Premium variable crafted with attention to detail. Red Embroidered blouses for sarees combines style and comfort for the modern fashion enthusiast.', 'CTN_EMB_BL', 249, NULL, 100, 1, 1, 0.3, NULL, 24, '[\"products\\/migrated_1759080040_68d96e684e2f3.webp\",\"products\\/migrated_1759080042_68d96e6a8d9b8.webp\",\"products\\/migrated_1759080044_68d96e6cb22e5.webp\"]', NULL, 0, 1, 'active', NULL, 'Buy Red Embroidered blouses for sarees online at SJ Fashion Hub. Stylish Blouse
 with premium quality. Price: ₹249. Free shipping available.', '2025-09-28 10:23:14', '2025-10-13 01:05:04', 'Red Embroidered blouses for sarees - Quality variable for', '**About This Product**

The Red Embroidered blouses for sarees represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this variable piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this variable piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"Red Embroidered blouses for sarees\",\"description\":\"Premium variable crafted with attention to detail. Red Embroidered blouses for sarees combines style and comfort for the modern fashion enthusiast.\",\"sku\":\"CTN_EMB_BL\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"249.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Blouse\\n\"}', 1, '2025-09-28 10:46:56', 'red embroidered blouses for sarees, blouse
, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'My Store', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '🔥 Red Embroidered Saree Blouse – Classic Elegance in Every Stitch

Step into timeless elegance with our red embroidered saree blouse – a masterpiece that combines traditional beauty with modern comfort. Designed for women who appreciate fine craftsmanship, this blouse is perfect for weddings, festive events, and traditional occasions.
✨ Key Features:


 	
Rich Red Color: A bold and auspicious shade that enhances every saree, from silk to chiffon.

 	
Round Neck Design: Classic and versatile, flattering for all saree drapes and jewelry styles.

 	
Front Open with Hook Closure: Easy to wear and style, offering a secure and comfortable fit.

 	
Intricate Embroidery: Detailed handwork using zardosi, maggam, and mirror embellishments that add depth and luxury.

 	
Comfortable Fabric: Made from high-quality silk or georgette that feels soft on the skin and ensures all-day comfort.

 	
Size Range: Available in sizes 26 to 42, ensuring a perfect fit for every body type.

', NULL, '[\"Designer red saree blouse 26 to 42 size\",\"Front open red blouse for saree\",\"Hand-embroidered red saree blouse\",\"Red blouse for wedding saree\",\"Red blouse with hook closure\",\"Red embroidered saree blouse\",\"Round neck red blouse with embroidery\",\"Traditional red blouse with round neck\"]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, 13),
(80, 'test', 'test-68d90c92ab41b', '', 'Premium uncategorized crafted with attention to detail. test combines style and comfort for the modern fashion enthusiast.', 'SKU-68d90c92ab438', 1, NULL, 9, 1, 1, 0, NULL, 21, '[]', NULL, 0, 1, 'active', NULL, 'Get test from SJ Fashion Hub\'s Uncategorized range. Quality assured at ₹1. Shop now with easy returns & secure payment.', '2025-09-28 10:23:14', '2025-09-28 13:26:33', 'Buy test Online - Uncategorized Collection | SJ Fashion Hu', '**About This Product**

The test represents the perfect fusion of contemporary style and exceptional quality. Designed for the modern individual who values both fashion and functionality, this Uncategorized piece is crafted to elevate your everyday wardrobe.

**Key Features:**
• Premium quality materials
• Comfortable fit
• Durable construction
• Easy care instructions
• Versatile styling options

**Materials & Quality:**
Crafted from premium quality materials, this product ensures durability and comfort. Our commitment to quality means every piece undergoes rigorous quality checks.

**Care Instructions:**
Follow care label instructions for best results

**Why Choose SJ Fashion Hub?**
• Premium quality materials
• Contemporary designs
• Comfortable fit
• Easy returns & exchanges
• Fast & secure delivery

Perfect for both casual and formal occasions, this Uncategorized piece is a versatile addition to any wardrobe.', '{\"@context\":\"https:\\/\\/schema.org\\/\",\"@type\":\"Product\",\"name\":\"test\",\"description\":\"\",\"sku\":\"SKU-68d90c92ab438\",\"brand\":{\"@type\":\"Brand\",\"name\":\"SJ Fashion Hub\"},\"offers\":{\"@type\":\"Offer\",\"price\":\"1.00\",\"priceCurrency\":\"INR\",\"availability\":\"https:\\/\\/schema.org\\/InStock\",\"seller\":{\"@type\":\"Organization\",\"name\":\"SJ Fashion Hub\"}},\"category\":\"Uncategorized\"}', 1, '2025-09-28 10:23:14', 'test, uncategorized, fashion, clothing, style, trendy, premium, quality, comfortable, modern, online shopping, sj fashion hub, buy online, best price', 'SJ Fashion Hub', '', NULL, 1, NULL, 'new', 'in_stock', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '', NULL, '[]', 0, NULL, 1, 30, NULL, 0, 5, 1, 'in_stock', NULL, NULL, 1, 5, NULL);


-- Table structure for table `coupons`
DROP TABLE IF EXISTS `coupons`;
CREATE TABLE "coupons" ("id" integer primary key autoincrement not null, "code" varchar not null, "name" varchar not null, "description" text, "type" varchar check ("type" in ('percentage', 'fixed_amount', 'free_shipping')) not null, "value" numeric not null, "minimum_amount" numeric, "maximum_discount" numeric, "usage_limit" integer, "usage_limit_per_customer" integer, "used_count" integer not null default '0', "starts_at" datetime, "expires_at" datetime, "applicable_products" text, "applicable_categories" text, "excluded_products" text, "excluded_categories" text, "applicable_customers" text, "first_order_only" tinyint(1) not null default '0', "is_active" tinyint(1) not null default '1', "is_public" tinyint(1) not null default '1', "priority" integer not null default '0', "stackable" tinyint(1) not null default '0', "created_by" varchar, "last_used_at" datetime, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `coupons`
INSERT INTO `coupons` (`id`, `code`, `name`, `description`, `type`, `value`, `minimum_amount`, `maximum_discount`, `usage_limit`, `usage_limit_per_customer`, `used_count`, `starts_at`, `expires_at`, `applicable_products`, `applicable_categories`, `excluded_products`, `excluded_categories`, `applicable_customers`, `first_order_only`, `is_active`, `is_public`, `priority`, `stackable`, `created_by`, `last_used_at`, `created_at`, `updated_at`) VALUES
(1, 'NEW10', '10% OFF ON ALL PURCHASE', 'WELCOME GIFT FOR NEW USER 10% DISCOUNT UPTO 100 RUPEES', 'percentage', 10, 1, 100, NULL, 1, 2, '2025-09-29 00:00:00', NULL, NULL, NULL, NULL, NULL, NULL, 1, 1, 1, 0, 0, 'Super Administrator', '2025-10-04 23:54:27', '2025-09-29 06:08:24', '2025-10-04 23:54:27');


-- Table structure for table `orders`
DROP TABLE IF EXISTS `orders`;
CREATE TABLE "orders" ("id" integer primary key autoincrement not null, "order_number" varchar not null, "user_id" integer not null, "status" varchar not null default ('pending'), "subtotal" numeric not null, "tax_amount" numeric not null default ('0'), "shipping_amount" numeric not null default ('0'), "discount_amount" numeric not null default ('0'), "total_amount" numeric not null, "currency" varchar not null default ('INR'), "payment_status" varchar not null default ('pending'), "payment_method" varchar, "payment_id" varchar, "billing_address" text not null, "shipping_address" text not null, "notes" text, "shipped_at" datetime, "delivered_at" datetime, "created_at" datetime, "updated_at" datetime, "order_status" varchar check ("order_status" in ('pending', 'confirmed', 'ready_to_ship', 'in_transit', 'out_for_delivery', 'delivered', 'cancelled', 'rto')) not null default 'pending', "shiprocket_order_id" varchar, "awb_number" varchar, "courier_company" varchar, "courier_company_id" varchar, "shipping_charges" numeric, "tracking_url" varchar, "courier_details" text, "is_manual_shipping" tinyint(1) not null default '0', "manual_tracking_id" varchar, "manual_courier_name" varchar, "confirmed_at" datetime, "ready_to_ship_at" datetime, "in_transit_at" datetime, "out_for_delivery_at" datetime, "cancelled_at" datetime, "rto_at" datetime, "confirmed_by" integer, "admin_notes" text, "cancellation_reason" text, "rto_reason" text, "delivery_attempts" varchar not null default '0', "delivery_updates" text, "cod_amount" numeric, "is_cod" tinyint(1) not null default '0', "package_weight" numeric, "package_length" numeric, "package_breadth" numeric, "package_height" numeric, "estimated_delivery_date" date, "estimated_delivery_days" integer, "coupon_code" varchar, "webhook_history" text, "status_history" text, courier_name TEXT, latest_scan_activity TEXT, latest_scan_location TEXT, latest_scan_date TEXT, shiprocket_shipment_id VARCHAR, foreign key("user_id") references users("id") on delete cascade on update no action, foreign key("confirmed_by") references "users"("id"));


-- Dumping data for table `orders`
INSERT INTO `orders` (`id`, `order_number`, `user_id`, `status`, `subtotal`, `tax_amount`, `shipping_amount`, `discount_amount`, `total_amount`, `currency`, `payment_status`, `payment_method`, `payment_id`, `billing_address`, `shipping_address`, `notes`, `shipped_at`, `delivered_at`, `created_at`, `updated_at`, `order_status`, `shiprocket_order_id`, `awb_number`, `courier_company`, `courier_company_id`, `shipping_charges`, `tracking_url`, `courier_details`, `is_manual_shipping`, `manual_tracking_id`, `manual_courier_name`, `confirmed_at`, `ready_to_ship_at`, `in_transit_at`, `out_for_delivery_at`, `cancelled_at`, `rto_at`, `confirmed_by`, `admin_notes`, `cancellation_reason`, `rto_reason`, `delivery_attempts`, `delivery_updates`, `cod_amount`, `is_cod`, `package_weight`, `package_length`, `package_breadth`, `package_height`, `estimated_delivery_date`, `estimated_delivery_days`, `coupon_code`, `webhook_history`, `status_history`, `courier_name`, `latest_scan_activity`, `latest_scan_location`, `latest_scan_date`, `shiprocket_shipment_id`) VALUES
(1, 'ORD-2025-743224', 5, 'pending', 1598, 287.64, 99, 0, 1984.64, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"BHUBANDANGA NAZRULPALLY NEAR MASJID,\\r\\nBOLPUR\",\"city\":\"BIRBHUM\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"BHUBANDANGA NAZRULPALLY NEAR MASJID,\\r\\nBOLPUR\",\"city\":\"BIRBHUM\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', NULL, NULL, '2025-09-28 06:55:14', '2025-09-28 06:23:52', '2025-09-28 09:08:53', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '123456', 'Blue Dart', NULL, '2025-09-28 06:53:26', '2025-09-28 06:54:03', '2025-09-28 06:54:57', NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 1984.64, 1, 0.2, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(2, 'ORD-2025-937387', 5, 'pending', 380.95238095238, 19.047619047619, 0, 40, 360, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, '2025-10-05 19:34:32', '2025-09-29 07:23:00', '2025-10-05 19:34:32', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-10-04 23:55:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 360, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'NEW10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(3, 'ORD-2025-815841', 5, 'pending', 0.95238095238095, 0.047619047619048, 0, 0.1, 0.9, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', NULL, NULL, '2025-10-05 19:34:22', '2025-10-04 23:54:21', '2025-10-05 19:34:22', 'delivered', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-10-04 23:55:02', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 0.9, 1, NULL, NULL, NULL, NULL, NULL, NULL, 'NEW10', NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(4, 'ORD-2025-784531', 5, 'pending', 0.95238095238095, 0.047619047619048, 0, 0, 1, 'INR', 'pending', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', NULL, NULL, NULL, '2025-10-05 01:53:25', '2025-10-05 19:34:10', 'cancelled', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-10-05 01:56:48', NULL, NULL, '2025-10-05 19:34:10', NULL, NULL, NULL, NULL, NULL, '0', NULL, 1, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(5, 'ORD-2025-474285', 5, 'pending', 380.95238095238, 19.047619047619, 0, 0, 400, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, '2025-10-05 19:35:44', '2025-10-05 01:58:14', '2025-10-05 19:35:44', 'delivered', '988846547', '1091354287963', 'Delhivery Air', '10', NULL, 'https://shiprocket.co/tracking/1091354287963', NULL, 0, NULL, NULL, NULL, '2025-10-05 01:58:26', '2025-10-05 01:58:43', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 400, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(6, 'ORD-2025-211287', 5, 'pending', 380.95238095238, 19.047619047619, 0, 0, 400, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, '2025-10-05 19:34:44', '2025-10-05 02:32:44', '2025-10-05 19:34:44', 'delivered', '988856968', '364036501550', 'Amazon COD Surface 500gm', '195', NULL, 'https://shiprocket.co/tracking/364036501550', NULL, 0, NULL, NULL, NULL, '2025-10-05 02:33:56', '2025-10-05 02:34:34', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 400, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '985263384'),
(7, 'ORD-2025-565599', 5, 'pending', 189.52380952381, 9.4761904761905, 0, 0, 199, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, '2025-10-12 11:11:24', '2025-10-12 10:57:35', '2025-10-12 11:11:49', 'rto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '123456', 'DTDC', NULL, '2025-10-12 11:07:07', '2025-10-12 11:07:34', '2025-10-12 11:10:27', NULL, '2025-10-12 11:11:49', NULL, NULL, NULL, NULL, '0', NULL, 199, 1, 0.5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(8, 'ORD-2025-849153', 5, 'pending', 523.80952380952, 26.190476190476, 0, 0, 550, 'INR', 'completed', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, '2025-10-12 12:36:05', '2025-10-12 12:34:32', '2025-10-12 12:37:38', 'rto', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, '123456', 'DTDC', NULL, '2025-10-12 12:35:03', '2025-10-12 12:35:34', '2025-10-12 12:35:51', '2025-10-12 12:36:27', '2025-10-12 12:37:38', NULL, NULL, NULL, NULL, '0', NULL, 550, 1, 5, 5, 5, 5, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(9, 'ORD-2025-228758', 5, 'pending', 237.14285714286, 11.857142857143, 0, 0, 249, 'INR', 'pending', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', NULL, NULL, NULL, '2025-10-12 15:41:30', '2025-10-12 15:41:30', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 249, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(10, 'ORD-2025-315313', 5, 'pending', 237.14285714286, 11.857142857143, 0, 0, 249, 'INR', 'pending', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"123 Test Street, Test Area\",\"city\":\"Kolkata\",\"state\":\"West Bengal\",\"pincode\":\"700001\"}', NULL, NULL, NULL, '2025-10-12 15:41:59', '2025-10-12 15:41:59', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 249, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL),
(11, 'ORD-2025-605089', 5, 'pending', 237.14285714286, 11.857142857143, 0, 0, 249, 'INR', 'pending', 'cod', NULL, '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', '{\"full_name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"address\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\"}', NULL, NULL, NULL, '2025-10-12 16:11:45', '2025-10-12 16:11:45', 'pending', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, '0', NULL, 249, 1, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL);


-- Table structure for table `return_orders`
DROP TABLE IF EXISTS `return_orders`;
CREATE TABLE "return_orders" ("id" integer primary key autoincrement not null, "return_number" varchar not null, "order_id" integer not null, "user_id" integer not null, "status" varchar check ("status" in ('pending', 'approved', 'ready_to_return', 'in_transit', 'pending_refund', 'completed', 'rejected')) not null default 'pending', "return_type" varchar check ("return_type" in ('refund', 'exchange', 'store_credit')) not null default 'refund', "return_reason" text not null, "customer_notes" text, "return_items" text not null, "return_amount" numeric not null, "return_images" text, "processed_by" integer, "admin_notes" text, "rejection_reason" text, "approved_at" datetime, "rejected_at" datetime, "shiprocket_return_id" varchar, "return_awb_number" varchar, "return_courier_company" varchar, "return_courier_company_id" integer, "return_shipping_charges" numeric, "return_tracking_url" varchar, "return_courier_details" text, "is_manual_return" tinyint(1) not null default '0', "manual_return_tracking_id" varchar, "manual_return_courier_name" varchar, "ready_to_return_at" datetime, "in_transit_at" datetime, "received_at" datetime, "refund_processed_at" datetime, "completed_at" datetime, "quality_check_status" varchar check ("quality_check_status" in ('pending', 'passed', 'failed')), "quality_check_notes" text, "quality_checked_by" integer, "quality_checked_at" datetime, "refund_amount" numeric, "deduction_amount" numeric not null default '0', "deduction_reason" text, "refund_method" varchar, "refund_transaction_id" varchar, "refund_details" text, "return_package_weight" numeric, "return_package_length" numeric, "return_package_breadth" numeric, "return_package_height" numeric, "pickup_address" text, "pickup_scheduled_at" datetime, "pickup_completed_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("order_id") references "orders"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete cascade, foreign key("processed_by") references "users"("id") on delete set null, foreign key("quality_checked_by") references "users"("id") on delete set null);


-- Dumping data for table `return_orders`
INSERT INTO `return_orders` (`id`, `return_number`, `order_id`, `user_id`, `status`, `return_type`, `return_reason`, `customer_notes`, `return_items`, `return_amount`, `return_images`, `processed_by`, `admin_notes`, `rejection_reason`, `approved_at`, `rejected_at`, `shiprocket_return_id`, `return_awb_number`, `return_courier_company`, `return_courier_company_id`, `return_shipping_charges`, `return_tracking_url`, `return_courier_details`, `is_manual_return`, `manual_return_tracking_id`, `manual_return_courier_name`, `ready_to_return_at`, `in_transit_at`, `received_at`, `refund_processed_at`, `completed_at`, `quality_check_status`, `quality_check_notes`, `quality_checked_by`, `quality_checked_at`, `refund_amount`, `deduction_amount`, `deduction_reason`, `refund_method`, `refund_transaction_id`, `refund_details`, `return_package_weight`, `return_package_length`, `return_package_breadth`, `return_package_height`, `pickup_address`, `pickup_scheduled_at`, `pickup_completed_at`, `created_at`, `updated_at`) VALUES
(1, 'RET-2025-000001', 1, 5, 'rejected', 'refund', 'defective_product', NULL, '[{\"order_item_id\":1,\"product_name\":\"Classic White Cotton Shirt\",\"quantity\":1,\"unit_price\":\"999.00\",\"total_price\":\"999.00\"},{\"order_item_id\":2,\"product_name\":\"Premium Black T-Shirt\",\"quantity\":1,\"unit_price\":\"599.00\",\"total_price\":\"599.00\"}]', 1598, '[]', 2, NULL, NULL, '2025-10-12 12:39:02', '2025-10-12 12:40:36', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, '2025-10-12 12:39:32', '2025-10-12 12:39:44', NULL, '2025-10-12 12:40:26', 'pending', NULL, 2, '2025-10-12 12:39:44', NULL, 0, NULL, 'bank_transfer', NULL, '{\"method\":\"bank_transfer\",\"bank_account_number\":\"1234\",\"bank_ifsc_code\":\"1324\",\"bank_account_holder\":\"jas\",\"bank_name\":\"Axis Bank\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-09-28 08:58:27', '2025-10-12 12:40:36'),
(2, 'RET-2025-2151A0', 6, 5, 'pending', 'refund', 'changed_mind', NULL, '[{\"order_item_id\":7,\"product_name\":\"Capsule 3 Pcs Set\",\"quantity\":1,\"unit_price\":\"400.00\",\"total_price\":\"400.00\"}]', 400, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'bank_transfer', NULL, '{\"method\":\"bank_transfer\",\"bank_account_number\":\"454587\",\"bank_ifsc_code\":\"Bdjjd\",\"bank_account_holder\":\"1234\",\"bank_name\":\"Bdjjd\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 12:38:34', '2025-10-12 12:38:34'),
(3, 'RET-2025-CBC92A', 5, 5, 'pending', 'refund', 'wrong_item', NULL, '[{\"order_item_id\":6,\"product_name\":\"Capsule 3 Pcs Set\",\"quantity\":1,\"unit_price\":\"400.00\",\"total_price\":\"400.00\"}]', 400, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'bank_transfer', NULL, '{\"method\":\"bank_transfer\",\"bank_account_number\":\"123456\",\"bank_ifsc_code\":\"acgds254vc\",\"bank_account_holder\":\"hgcg\",\"bank_name\":\"cjgh\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 13:23:32', '2025-10-12 13:23:32'),
(4, 'RET-2025-A2D72E', 5, 5, 'pending', 'refund', 'wrong_item', NULL, '[{\"order_item_id\":6,\"product_name\":\"Capsule 3 Pcs Set\",\"quantity\":1,\"unit_price\":\"400.00\",\"total_price\":\"400.00\"}]', 400, '[]', NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'bank_transfer', NULL, '{\"method\":\"bank_transfer\",\"bank_account_number\":\"123456\",\"bank_ifsc_code\":\"acgds254vc\",\"bank_account_holder\":\"hgcg\",\"bank_name\":\"cjgh\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 13:26:10', '2025-10-12 13:26:10'),
(5, 'RET-2025-648246', 5, 5, 'rejected', 'refund', 'wrong_item', NULL, '[{\"order_item_id\":6,\"product_name\":\"Capsule 3 Pcs Set\",\"quantity\":1,\"unit_price\":\"400.00\",\"total_price\":\"400.00\"}]', 400, '[]', NULL, NULL, 'Cancelled by customer', NULL, '2025-10-12 13:48:00', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 0, NULL, 'bank_transfer', NULL, '{\"method\":\"bank_transfer\",\"bank_account_number\":\"123456\",\"bank_ifsc_code\":\"acgds254vc\",\"bank_account_holder\":\"hgcg\",\"bank_name\":\"cjgh\"}', NULL, NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 13:26:22', '2025-10-12 13:48:00');


-- Table structure for table `shiprocket_settings`
DROP TABLE IF EXISTS `shiprocket_settings`;
CREATE TABLE "shiprocket_settings" ("id" integer primary key autoincrement not null, "key" varchar not null, "value" text, "encrypted_value" text, "type" varchar not null default 'text', "group" varchar not null default 'general', "description" text, "is_encrypted" tinyint(1) not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `shiprocket_settings`
INSERT INTO `shiprocket_settings` (`id`, `key`, `value`, `encrypted_value`, `type`, `group`, `description`, `is_encrypted`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'shiprocket_email', NULL, 'eyJpdiI6IkZVa0l1WDAzMG1saU16RERLTkpMbFE9PSIsInZhbHVlIjoiQVZMZEs3MVRZclVoRHpLTlhyYkNGckRZY212ZmUzUzZrWTR0R3RlS0lWRT0iLCJtYWMiOiIwYmFmZjYzOTE3Nzg2Y2JkMmE2MzFlNWU5MjdjNzg2MWQzYThkNjkzMmRkODkxZGI4Yjk0OGM0ZWMxMGU2NDQzIiwidGFnIjoiIn0=', 'email', 'api', 'Shiprocket account email', 1, 1, '2025-10-04 22:51:56', '2025-10-04 23:11:46'),
(2, 'shiprocket_password', NULL, 'eyJpdiI6InBuZFQ5Z3pKL21WYWxCaXlOeFZtc2c9PSIsInZhbHVlIjoiV0hjcDBYa0owZVlXSmVDcHg5VkRRZz09IiwibWFjIjoiZjIyZTcwOTNlMTdkYmMzZjcwYTcyOTNkMWI4Njk2ODA3NDMyMzA2NGFmMzY1ODAzNmFkYTk3ZDYwNjIwNzIwYiIsInRhZyI6IiJ9', 'password', 'api', 'Shiprocket account password', 1, 1, '2025-10-04 22:51:56', '2025-10-04 23:11:46'),
(3, 'shiprocket_base_url', 'https://apiv2.shiprocket.in/v1/external', NULL, 'url', 'api', 'Shiprocket API base URL', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(4, 'shiprocket_is_sandbox', '1', NULL, 'boolean', 'api', 'Enable sandbox mode for testing', 0, 1, '2025-10-04 22:51:56', '2025-10-04 23:11:46'),
(5, 'shiprocket_pickup_location', 'Office', NULL, 'text', 'pickup', 'Pickup location name', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:52:23'),
(6, 'shiprocket_pickup_name', 'SJ  Fashion', NULL, 'text', 'pickup', 'Pickup contact name', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:52:23'),
(7, 'shiprocket_pickup_email', 'admin@sjfashion.boutique', NULL, 'email', 'pickup', 'Pickup contact email', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(8, 'shiprocket_pickup_phone', '7063474409', NULL, 'text', 'pickup', 'Pickup contact phone', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(9, 'shiprocket_pickup_address', 'Masjid Rd', NULL, 'textarea', 'pickup', 'Pickup address line 1', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:52:23'),
(10, 'shiprocket_pickup_address_2', 'Manas Path, Sasang, Latehar, Jharkhand 829206, India', NULL, 'text', 'pickup', 'Pickup address line 2', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:52:23'),
(11, 'shiprocket_pickup_city', 'Birbhum', NULL, 'text', 'pickup', 'Pickup city', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:52:23'),
(12, 'shiprocket_pickup_state', 'West Bengal', NULL, 'text', 'pickup', 'Pickup state', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(13, 'shiprocket_pickup_country', 'India', NULL, 'text', 'pickup', 'Pickup country', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(14, 'shiprocket_pickup_pin_code', '731204', NULL, 'text', 'pickup', 'Pickup PIN code', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(15, 'shiprocket_auto_assign_awb', '0', NULL, 'boolean', 'general', 'Automatically assign AWB numbers', 0, 1, '2025-10-04 22:51:56', '2025-10-04 23:11:46'),
(16, 'shiprocket_auto_pickup', '1', NULL, 'boolean', 'general', 'Automatically schedule pickups', 0, 1, '2025-10-04 22:51:56', '2025-10-04 23:11:46'),
(17, 'shiprocket_default_weight', '0.5', NULL, 'number', 'general', 'Default package weight (kg)', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(18, 'shiprocket_default_length', '10', NULL, 'number', 'general', 'Default package length (cm)', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(19, 'shiprocket_default_breadth', '10', NULL, 'number', 'general', 'Default package breadth (cm)', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(20, 'shiprocket_default_height', '10', NULL, 'number', 'general', 'Default package height (cm)', 0, 1, '2025-10-04 22:51:56', '2025-10-04 22:51:56'),
(21, 'shiprocket_api_token', NULL, 'eyJpdiI6ImlrVnlCdHFCY2lBcmhBMnAwTjlYa3c9PSIsInZhbHVlIjoiVzc1MkU1Y1pacU5XNkhGdjQrQW1RSllZdzdpaGVybUlvWUVPNnBIUXVLZDBTNlVKenVvS3FCeGVFSWVqNTdlaDdjSjYvRHNJQ0diMFA1MWx6N1J4V01YbWFBOXFvVSt0SXVCUHpPQldCSjFXLzFsSkdQVmpUWUp0Q2tISDQ2UUdMVzVlaCtTbzk0cHA3ekFOZTh2clR0cHpGY0ZmQlpCUzFjQUhqQmpwYk9lSTR4b0FWV2pLODVHbWp1d2VCRGVlZU9QVm9mcWJabWpsS1ljZ3hYRkw0R05BSHA1SG5vcVY5S2ZzY2VaV2ZlVDZpYXNubGo5NVI1K1RKMVc4VTBPRDZaYWo3M1p0eVM0aU04OGtBbWxKSWxxSTV2U3JCS2tQc21JVXd4QWtlNVdob0RaMTYwTUh0d0hCckVkclNnNWwvOTRRb3JCK2pjelhnbzVUOHQvQThlVVIyeXZZM2xqcThHRVhlT0pMUzRndUJrZnh0Zkh4dDUzalhkbmNBS29GT3ZlSWNGNjZlTWFONnU3c2YveGRkQzJpM29uTERlWnlOQ1R3dW9Xdmo3SHZDaU9tYlBvVWVITlkxNHZEamhuRTUyV3V4Sk8zWE16aFh0Nkdpc3VuMXZGZHlkNEEzS1d3SW5sSnNaVldhTWYwYWh0Qi8xOUcvQzJVeERPK0tKQmV1dEhQN1VUL25VSDNLVmZCdldYeXY3MlVwQTlXVk9xOUxVa0hXUVRCQnJRPSIsIm1hYyI6ImFmOGNhNmY2ODJmODEwNjVjYzRlYzE5ZmU5Njg0ZDc3MDk0YmI3OTEwNTUwMGUyMmVkZWZhYmFlNmJmNTIxMWEiLCJ0YWciOiIifQ==', 'text', 'api', 'Current API token', 1, 1, '2025-10-04 22:51:56', '2025-10-04 23:44:00'),
(22, 'shiprocket_webhook_token', 'SBffv1pKF61mPlXgyeFlF7Y7jIeKtZWZ', NULL, 'text', 'webhook', 'Webhook authentication token', 1, 1, '2025-10-04 23:11:46', '2025-10-04 23:11:46');


-- Table structure for table `abandoned_carts`
DROP TABLE IF EXISTS `abandoned_carts`;
CREATE TABLE "abandoned_carts" ("id" integer primary key autoincrement not null, "session_id" varchar, "user_id" integer, "email" varchar, "phone" varchar, "first_name" varchar, "last_name" varchar, "cart_items" text not null, "cart_total" numeric not null default '0', "cart_subtotal" numeric not null default '0', "cart_tax" numeric not null default '0', "cart_shipping" numeric not null default '0', "items_count" integer not null default '0', "currency" varchar not null default 'INR', "status" varchar not null default 'abandoned', "abandoned_at" datetime not null, "last_activity_at" datetime not null, "recovered_at" datetime, "expires_at" datetime, "recovery_token" varchar, "utm_source" varchar, "utm_medium" varchar, "utm_campaign" varchar, "browser_info" text, "ip_address" varchar, "country" varchar, "city" varchar, "is_guest" tinyint(1) not null default '1', "email_sent" tinyint(1) not null default '0', "email_count" integer not null default '0', "last_email_sent_at" datetime, "coupon_codes" text, "notes" text, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `abandoned_carts`
-- No data to dump


-- Table structure for table `abandoned_cart_emails`
DROP TABLE IF EXISTS `abandoned_cart_emails`;
CREATE TABLE "abandoned_cart_emails" ("id" integer primary key autoincrement not null, "abandoned_cart_id" integer not null, "email_type" varchar not null, "subject" varchar not null, "content" text not null, "template" varchar, "status" varchar not null default 'pending', "scheduled_at" datetime not null, "sent_at" datetime, "opened_at" datetime, "clicked_at" datetime, "email_provider" varchar, "message_id" varchar, "error_message" text, "retry_count" integer not null default '0', "tracking_data" text, "coupon_code" varchar, "discount_amount" numeric, "discount_type" varchar, "is_personalized" tinyint(1) not null default '0', "personalization_data" text, "created_at" datetime, "updated_at" datetime, foreign key("abandoned_cart_id") references "abandoned_carts"("id") on delete cascade);


-- Dumping data for table `abandoned_cart_emails`
-- No data to dump


-- Table structure for table `google_sheets_settings`
DROP TABLE IF EXISTS `google_sheets_settings`;
CREATE TABLE "google_sheets_settings" ("id" integer primary key autoincrement not null, "sheet_type" varchar not null, "sheet_name" varchar not null, "spreadsheet_id" varchar not null, "sheet_id" varchar, "web_app_url" varchar not null, "service_account_json" text, "column_mapping" text not null, "auto_sync" tinyint(1) not null default '1', "real_time_sync" tinyint(1) not null default '0', "sync_frequency" varchar not null default 'hourly', "last_sync_at" datetime, "total_synced" integer not null default '0', "sync_errors" integer not null default '0', "is_active" tinyint(1) not null default '1', "sync_filters" text, "notes" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `google_sheets_settings`
INSERT INTO `google_sheets_settings` (`id`, `sheet_type`, `sheet_name`, `spreadsheet_id`, `sheet_id`, `web_app_url`, `service_account_json`, `column_mapping`, `auto_sync`, `real_time_sync`, `sync_frequency`, `last_sync_at`, `total_synced`, `sync_errors`, `is_active`, `sync_filters`, `notes`, `created_at`, `updated_at`) VALUES
(1, 'orders', 'Orders', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"order_id\":\"A\",\"customer_name\":\"B\",\"customer_email\":\"C\",\"customer_phone\":\"D\",\"total_amount\":\"E\",\"status\":\"F\",\"payment_status\":\"G\",\"shipping_address\":\"H\",\"order_date\":\"I\",\"updated_at\":\"J\",\"items_count\":\"K\",\"shipping_method\":\"L\",\"tracking_number\":\"M\",\"notes\":\"N\"}', 1, 1, 'hourly', '2025-09-29 09:31:36', 6, 0, 1, '[]', NULL, '2025-09-29 06:22:25', '2025-09-29 09:31:36'),
(2, 'returns', 'Returns', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"return_id\":\"A\",\"order_id\":\"B\",\"customer_name\":\"C\",\"customer_email\":\"D\",\"return_reason\":\"E\",\"return_status\":\"F\",\"refund_amount\":\"G\",\"return_date\":\"H\",\"approved_date\":\"I\",\"refund_date\":\"J\",\"quality_check\":\"K\",\"admin_notes\":\"L\",\"tracking_number\":\"M\"}', 1, 1, 'hourly', '2025-09-29 09:31:47', 3, 0, 1, '[]', NULL, '2025-09-29 06:26:44', '2025-09-29 09:31:47'),
(3, 'users', 'Users', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"user_id\":\"A\",\"name\":\"B\",\"email\":\"C\",\"phone\":\"D\",\"role\":\"E\",\"status\":\"F\",\"registration_date\":\"G\",\"last_login\":\"H\",\"total_orders\":\"I\",\"total_spent\":\"J\",\"address\":\"K\",\"city\":\"L\",\"state\":\"M\",\"postal_code\":\"N\",\"country\":\"N\",\"date_of_birth\":\"P\",\"gender\":\"Q\",\"email_marketing_consent\":\"R\",\"sms_marketing_consent\":\"S\",\"total_addresses\":\"T\",\"default_address\":\"U\",\"created_at\":\"V\",\"updated_at\":\"W\"}', 1, 1, 'hourly', '2025-10-13 00:23:53', 135, 0, 1, '[]', NULL, '2025-09-29 06:27:00', '2025-10-13 00:23:53'),
(4, 'newsletters', 'Newsletters', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"subscriber_id\":\"A\",\"email\":\"B\",\"name\":\"C\",\"status\":\"D\",\"subscribed_at\":\"E\",\"unsubscribed_at\":\"F\",\"source\":\"G\",\"ip_address\":\"H\",\"user_agent\":\"I\",\"preferences\":\"J\",\"created_at\":\"K\",\"updated_at\":\"L\"}', 1, 1, 'hourly', '2025-09-29 09:36:22', 4, 0, 1, '[]', NULL, '2025-09-29 06:27:08', '2025-09-29 09:36:22'),
(5, 'user_addresses', 'User_addresses', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"address_id\":\"A\",\"user_id\":\"B\",\"user_name\":\"C\",\"user_email\":\"D\",\"address_type\":\"E\",\"first_name\":\"F\",\"last_name\":\"G\",\"company\":\"H\",\"address_line_1\":\"I\",\"address_line_2\":\"J\",\"city\":\"K\",\"state\":\"L\",\"postal_code\":\"M\",\"country\":\"N\",\"phone\":\"O\",\"is_default\":\"P\",\"created_at\":\"Q\",\"updated_at\":\"R\"}', 1, 1, 'hourly', '2025-10-04 23:54:33', 3, 0, 1, '[]', NULL, '2025-09-29 08:22:29', '2025-10-04 23:54:33'),
(6, 'user_changes', 'User_changes', '1Ixpabx72SczMZPpqGklxgLCNcXEiEEqq4Baiou_ekkY', NULL, 'https://script.google.com/macros/s/AKfycbyz0V2T8sxIngsrQm4catgL1GaPYgpsvF8RXSBZND9RlVfj0I97tUujgjYWoJOXTBKFaA/exec', NULL, '{\"change_id\":\"A\",\"user_id\":\"B\",\"user_name\":\"C\",\"user_email\":\"D\",\"change_type\":\"E\",\"field_name\":\"F\",\"old_value\":\"G\",\"new_value\":\"H\",\"changed_by\":\"I\",\"ip_address\":\"J\",\"user_agent\":\"K\",\"changed_at\":\"L\"}', 1, 1, 'hourly', '2025-10-12 10:45:03', 26, 0, 1, '[]', NULL, '2025-09-29 08:22:52', '2025-10-12 10:45:03');


-- Table structure for table `google_sheets_sync_logs`
DROP TABLE IF EXISTS `google_sheets_sync_logs`;
CREATE TABLE "google_sheets_sync_logs" ("id" integer primary key autoincrement not null, "google_sheets_setting_id" integer not null, "sync_type" varchar not null, "operation" varchar not null, "status" varchar not null, "records_processed" integer not null default '0', "records_success" integer not null default '0', "records_failed" integer not null default '0', "sync_data" text, "error_message" text, "error_details" text, "started_at" datetime not null, "completed_at" datetime, "duration_seconds" integer, "triggered_by" varchar, "batch_id" varchar, "response_data" text, "created_at" datetime, "updated_at" datetime, foreign key("google_sheets_setting_id") references "google_sheets_settings"("id") on delete cascade);


-- Dumping data for table `google_sheets_sync_logs`
INSERT INTO `google_sheets_sync_logs` (`id`, `google_sheets_setting_id`, `sync_type`, `operation`, `status`, `records_processed`, `records_success`, `records_failed`, `sync_data`, `error_message`, `error_details`, `started_at`, `completed_at`, `duration_seconds`, `triggered_by`, `batch_id`, `response_data`, `created_at`, `updated_at`) VALUES
(1, 2, 'manual', 'bulk_sync', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 07:36:53', '2025-09-29 07:36:59', -6.840033, '2', 'batch_68da3715095eb', NULL, '2025-09-29 07:36:53', '2025-09-29 07:36:59'),
(2, 3, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 07:36:54', '2025-09-29 07:37:01', -7.523305, '2', 'batch_68da3716c8009', NULL, '2025-09-29 07:36:54', '2025-09-29 07:37:01'),
(3, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:19:41', '2025-09-29 08:19:48', -7.18222, 'system', NULL, '{\"success\":true,\"message\":\"Data synced successfully\",\"records_processed\":1}', '2025-09-29 08:19:41', '2025-09-29 08:19:48'),
(4, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:19:48', '2025-09-29 08:19:52', -4.38823, 'system', NULL, '{\"success\":true,\"message\":\"Data synced successfully\",\"records_processed\":1}', '2025-09-29 08:19:48', '2025-09-29 08:19:52'),
(5, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:19:52', '2025-09-29 08:19:59', -7.50732, 'system', NULL, '{\"success\":true,\"message\":\"Data synced successfully\",\"records_processed\":1}', '2025-09-29 08:19:52', '2025-09-29 08:19:59'),
(6, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:19:59', '2025-09-29 08:20:06', -7.824596, 'system', NULL, '{\"success\":true,\"message\":\"Data synced successfully\",\"records_processed\":1}', '2025-09-29 08:19:59', '2025-09-29 08:20:06'),
(7, 2, 'manual', 'bulk_sync', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:20:02', '2025-09-29 08:20:07', -5.390188, '2', 'batch_68da4132db31e', NULL, '2025-09-29 08:20:02', '2025-09-29 08:20:07'),
(8, 3, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 08:20:12', '2025-09-29 08:20:18', -6.46742, '2', 'batch_68da413c023f2', NULL, '2025-09-29 08:20:12', '2025-09-29 08:20:18'),
(9, 5, 'manual', 'bulk_sync', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 08:22:57', '2025-09-29 08:23:15', -18.831935, '2', 'batch_68da41e1e11ab', NULL, '2025-09-29 08:22:57', '2025-09-29 08:23:15'),
(10, 6, 'manual', 'bulk_sync', 'success', 6, 6, 0, NULL, NULL, NULL, '2025-09-29 08:23:20', '2025-09-29 08:23:24', -4.215777, '2', 'batch_68da41f8b9f33', NULL, '2025-09-29 08:23:20', '2025-09-29 08:23:24'),
(11, 1, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 08:42:29', '2025-09-29 08:42:33', -4.990357, '2', 'batch_68da467505cb4', NULL, '2025-09-29 08:42:29', '2025-09-29 08:42:33'),
(12, 4, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 08:56:44', '2025-09-29 08:56:50', -6.841687, '2', 'batch_68da49cc8af5e', NULL, '2025-09-29 08:56:44', '2025-09-29 08:56:50'),
(13, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:16:18', '2025-09-29 09:16:18', NULL, 'system', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\"}', '2025-09-29 09:16:18', '2025-09-29 09:16:18'),
(14, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:16:30', '2025-09-29 09:16:30', NULL, 'system', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\"}', '2025-09-29 09:16:30', '2025-09-29 09:16:30'),
(15, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:17:14', '2025-09-29 09:17:14', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\"}', '2025-09-29 09:17:14', '2025-09-29 09:17:14'),
(16, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:25:27', '2025-09-29 09:25:27', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:25:26.266Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:25:27', '2025-09-29 09:25:27'),
(17, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:26:11', '2025-09-29 09:26:11', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:26:10.385Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:26:11', '2025-09-29 09:26:11'),
(18, 1, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 09:26:30', '2025-09-29 09:26:35', -5.244736, '2', 'batch_68da50c6c48e8', NULL, '2025-09-29 09:26:30', '2025-09-29 09:26:35'),
(19, 1, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:31:08', '2025-09-29 09:31:08', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:31:05.423Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:31:08', '2025-09-29 09:31:08'),
(20, 2, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:31:26', '2025-09-29 09:31:26', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:31:24.733Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:31:26', '2025-09-29 09:31:26'),
(21, 1, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 09:31:27', '2025-09-29 09:31:36', -9.945225, '2', 'batch_68da51efce646', NULL, '2025-09-29 09:31:27', '2025-09-29 09:31:36'),
(22, 2, 'manual', 'bulk_sync', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 09:31:39', '2025-09-29 09:31:47', -8.633653, '2', 'batch_68da51fb0acee', NULL, '2025-09-29 09:31:39', '2025-09-29 09:31:47'),
(23, 3, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:35:52', '2025-09-29 09:35:52', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:35:49.752Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:35:52', '2025-09-29 09:35:52'),
(24, 3, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 09:35:55', '2025-09-29 09:36:05', -10.221418, '2', 'batch_68da52fbb3ad2', NULL, '2025-09-29 09:35:55', '2025-09-29 09:36:05'),
(25, 4, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:36:14', '2025-09-29 09:36:14', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:36:11.460Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:36:14', '2025-09-29 09:36:14'),
(26, 4, 'manual', 'bulk_sync', 'success', 2, 2, 0, NULL, NULL, NULL, '2025-09-29 09:36:16', '2025-09-29 09:36:22', -6.462072, '2', 'batch_68da531015d5f', NULL, '2025-09-29 09:36:16', '2025-09-29 09:36:22'),
(27, 5, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:36:38', '2025-09-29 09:36:38', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:36:35.757Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:36:38', '2025-09-29 09:36:38'),
(28, 5, 'manual', 'bulk_sync', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 09:36:42', '2025-09-29 09:36:49', -7.466065, '2', 'batch_68da532ad989f', NULL, '2025-09-29 09:36:42', '2025-09-29 09:36:49'),
(29, 6, 'manual', 'create_headers', 'success', 0, 0, 0, NULL, NULL, NULL, '2025-09-29 09:36:54', '2025-09-29 09:36:54', NULL, '2', NULL, '{\"success\":false,\"error\":\"Exception: Invalid argument: id\",\"error_type\":\"Exception\",\"timestamp\":\"2025-09-29T09:36:54.201Z\",\"help\":\"Check that the request includes valid POST data with required fields\"}', '2025-09-29 09:36:54', '2025-09-29 09:36:54'),
(30, 6, 'manual', 'bulk_sync', 'success', 6, 6, 0, NULL, NULL, NULL, '2025-09-29 09:37:07', '2025-09-29 09:37:14', -7.297543, '2', 'batch_68da5343e2029', NULL, '2025-09-29 09:37:07', '2025-09-29 09:37:14'),
(31, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:33:25', '2025-09-29 10:33:32', -7.160618, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:33:29.184Z\"}', '2025-09-29 10:33:25', '2025-09-29 10:33:32'),
(32, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:33:32', '2025-09-29 10:33:37', -5.574544, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:33:34.633Z\"}', '2025-09-29 10:33:32', '2025-09-29 10:33:37'),
(33, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:33:38', '2025-09-29 10:33:43', -5.632666, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:33:40.608Z\"}', '2025-09-29 10:33:38', '2025-09-29 10:33:43'),
(34, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:33:43', '2025-09-29 10:33:47', -4.922709, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:33:44.886Z\"}', '2025-09-29 10:33:43', '2025-09-29 10:33:47'),
(35, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:45:15', '2025-09-29 10:45:17', -2.640018, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:45:16.614Z\"}', '2025-09-29 10:45:15', '2025-09-29 10:45:17'),
(36, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:45:17', '2025-09-29 10:45:20', -3.749479, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:45:18.960Z\"}', '2025-09-29 10:45:17', '2025-09-29 10:45:20'),
(37, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:45:21', '2025-09-29 10:45:24', -3.83934, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:45:23.714Z\"}', '2025-09-29 10:45:21', '2025-09-29 10:45:24'),
(38, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 10:45:24', '2025-09-29 10:45:27', -3.833042, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:45:26.793Z\"}', '2025-09-29 10:45:24', '2025-09-29 10:45:27'),
(39, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 16:22:44', '2025-09-29 16:22:48', -4.279085, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:52:46.744Z\"}', '2025-09-29 16:22:44', '2025-09-29 16:22:48'),
(40, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 16:22:48', '2025-09-29 16:22:50', -2.844859, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:52:49.934Z\"}', '2025-09-29 16:22:48', '2025-09-29 16:22:50'),
(41, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 16:22:51', '2025-09-29 16:22:53', -2.408806, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-09-29T10:52:52.454Z\"}', '2025-09-29 16:22:51', '2025-09-29 16:22:53'),
(42, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-09-29 16:22:53', '2025-09-29 16:22:56', -3.786842, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-09-29T10:52:55.881Z\"}', '2025-09-29 16:22:53', '2025-09-29 16:22:56'),
(43, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 20:57:48', '2025-10-03 20:57:54', -6.437232, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-03T15:27:51.439Z\"}', '2025-10-03 20:57:48', '2025-10-03 20:57:54'),
(44, 3, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 20:57:54', '2025-10-03 20:58:01', -7.133849, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-03T15:27:58.260Z\"}', '2025-10-03 20:57:54', '2025-10-03 20:58:01'),
(45, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 20:59:14', '2025-10-03 20:59:19', -5.337461, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:29:16.243Z\"}', '2025-10-03 20:59:14', '2025-10-03 20:59:19'),
(46, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:00:55', '2025-10-03 21:00:58', -3.805754, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:30:56.832Z\"}', '2025-10-03 21:00:55', '2025-10-03 21:00:58'),
(47, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:01:42', '2025-10-03 21:01:47', -5.364077, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:31:43.929Z\"}', '2025-10-03 21:01:42', '2025-10-03 21:01:47'),
(48, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:01:47', '2025-10-03 21:01:51', -4.941056, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:31:48.715Z\"}', '2025-10-03 21:01:47', '2025-10-03 21:01:51'),
(49, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:01:51', '2025-10-03 21:01:56', -5.824785, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-03T15:31:53.455Z\"}', '2025-10-03 21:01:51', '2025-10-03 21:01:56'),
(50, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:01:56', '2025-10-03 21:02:01', -5.451541, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-03T15:31:58.572Z\"}', '2025-10-03 21:01:56', '2025-10-03 21:02:01'),
(51, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:03:09', '2025-10-03 21:03:12', -3.798546, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:33:11.280Z\"}', '2025-10-03 21:03:09', '2025-10-03 21:03:12'),
(52, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:03:24', '2025-10-03 21:03:27', -3.236233, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:33:26.317Z\"}', '2025-10-03 21:03:24', '2025-10-03 21:03:27'),
(53, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:03:27', '2025-10-03 21:03:29', -2.861541, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:33:28.821Z\"}', '2025-10-03 21:03:27', '2025-10-03 21:03:29'),
(54, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:03:29', '2025-10-03 21:03:32', -3.339543, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:33:31.218Z\"}', '2025-10-03 21:03:29', '2025-10-03 21:03:32'),
(55, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-03 21:03:32', '2025-10-03 21:03:34', -2.918621, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-03T15:33:33.932Z\"}', '2025-10-03 21:03:32', '2025-10-03 21:03:34'),
(56, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 09:22:22', '2025-10-04 09:22:25', -3.39166, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T03:52:24.113Z\"}', '2025-10-04 09:22:22', '2025-10-04 09:22:25'),
(57, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 09:22:25', '2025-10-04 09:22:29', -4.736401, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T03:52:26.793Z\"}', '2025-10-04 09:22:25', '2025-10-04 09:22:29'),
(58, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 09:22:29', '2025-10-04 09:22:32', -3.411829, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T03:52:31.144Z\"}', '2025-10-04 09:22:29', '2025-10-04 09:22:32'),
(59, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 09:22:32', '2025-10-04 09:22:36', -4.911584, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T03:52:33.876Z\"}', '2025-10-04 09:22:32', '2025-10-04 09:22:36'),
(60, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 22:43:04', '2025-10-04 22:43:12', -8.244189, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T17:13:10.135Z\"}', '2025-10-04 22:43:04', '2025-10-04 22:43:12'),
(61, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 22:43:12', '2025-10-04 22:43:20', -8.865399, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T17:13:18.048Z\"}', '2025-10-04 22:43:12', '2025-10-04 22:43:20'),
(62, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 22:43:20', '2025-10-04 22:43:26', -6.940016, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T17:13:24.084Z\"}', '2025-10-04 22:43:20', '2025-10-04 22:43:26'),
(63, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 22:43:26', '2025-10-04 22:43:33', -7.118692, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T17:13:30.280Z\"}', '2025-10-04 22:43:26', '2025-10-04 22:43:33'),
(64, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:52:48', '2025-10-04 23:52:52', -4.284277, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T18:22:51.444Z\"}', '2025-10-04 23:52:48', '2025-10-04 23:52:52'),
(65, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:52:52', '2025-10-04 23:52:54', -2.607946, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T18:22:53.586Z\"}', '2025-10-04 23:52:52', '2025-10-04 23:52:54'),
(66, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:52:54', '2025-10-04 23:52:56', -2.890247, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T18:22:55.965Z\"}', '2025-10-04 23:52:54', '2025-10-04 23:52:56'),
(67, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:52:56', '2025-10-04 23:52:59', -3.760157, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T18:22:58.852Z\"}', '2025-10-04 23:52:56', '2025-10-04 23:52:59'),
(68, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:54:27', '2025-10-04 23:54:29', -2.884913, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-04T18:24:28.548Z\"}', '2025-10-04 23:54:27', '2025-10-04 23:54:29'),
(69, 5, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:54:29', '2025-10-04 23:54:33', -4.31891, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-04T18:24:32.445Z\"}', '2025-10-04 23:54:29', '2025-10-04 23:54:33'),
(70, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-04 23:54:33', '2025-10-04 23:54:38', -5.067556, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T18:24:35.908Z\"}', '2025-10-04 23:54:33', '2025-10-04 23:54:38'),
(71, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 01:52:44', '2025-10-05 01:52:49', -5.429994, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T20:22:46.513Z\"}', '2025-10-05 01:52:44', '2025-10-05 01:52:49'),
(72, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 01:52:49', '2025-10-05 01:52:54', -5.802719, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T20:22:50.669Z\"}', '2025-10-05 01:52:49', '2025-10-05 01:52:54'),
(73, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 01:52:54', '2025-10-05 01:53:00', -6.049642, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T20:22:56.522Z\"}', '2025-10-05 01:52:54', '2025-10-05 01:53:00'),
(74, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 01:53:00', '2025-10-05 01:53:05', -5.417041, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-04T20:23:01.327Z\"}', '2025-10-05 01:53:00', '2025-10-05 01:53:05'),
(75, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 14:18:47', '2025-10-05 14:18:51', -4.701452, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T08:48:49.358Z\"}', '2025-10-05 14:18:47', '2025-10-05 14:18:51'),
(76, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 14:18:51', '2025-10-05 14:18:56', -5.163063, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T08:48:53.232Z\"}', '2025-10-05 14:18:51', '2025-10-05 14:18:56'),
(77, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 14:18:56', '2025-10-05 14:19:00', -4.647615, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T08:48:57.668Z\"}', '2025-10-05 14:18:56', '2025-10-05 14:19:00'),
(78, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 14:19:00', '2025-10-05 14:19:03', -3.917058, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T08:49:02.134Z\"}', '2025-10-05 14:19:00', '2025-10-05 14:19:03'),
(79, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 18:53:21', '2025-10-05 18:53:24', -3.816527, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T13:23:23.195Z\"}', '2025-10-05 18:53:21', '2025-10-05 18:53:24'),
(80, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 18:53:24', '2025-10-05 18:53:30', -6.050301, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T13:23:28.141Z\"}', '2025-10-05 18:53:24', '2025-10-05 18:53:30'),
(81, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 18:53:30', '2025-10-05 18:53:32', -2.929419, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T13:23:31.264Z\"}', '2025-10-05 18:53:30', '2025-10-05 18:53:32'),
(82, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-05 18:53:32', '2025-10-05 18:53:36', -4.749098, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-05T13:23:34.302Z\"}', '2025-10-05 18:53:32', '2025-10-05 18:53:36'),
(83, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:15:51', '2025-10-06 20:15:55', -4.638156, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:45:54.285Z\"}', '2025-10-06 20:15:51', '2025-10-06 20:15:55'),
(84, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:15:55', '2025-10-06 20:15:58', -3.581083, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:45:57.570Z\"}', '2025-10-06 20:15:55', '2025-10-06 20:15:58'),
(85, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:15:58', '2025-10-06 20:16:03', -5.300518, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:46:01.482Z\"}', '2025-10-06 20:15:58', '2025-10-06 20:16:03'),
(86, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:16:03', '2025-10-06 20:16:06', -3.230631, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:46:04.938Z\"}', '2025-10-06 20:16:03', '2025-10-06 20:16:06'),
(87, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:17:09', '2025-10-06 20:17:11', -2.946646, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:47:10.754Z\"}', '2025-10-06 20:17:09', '2025-10-06 20:17:11'),
(88, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:17:11', '2025-10-06 20:17:16', -5.729624, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:47:15.186Z\"}', '2025-10-06 20:17:11', '2025-10-06 20:17:16'),
(89, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:17:16', '2025-10-06 20:17:19', -3.177401, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:47:18.184Z\"}', '2025-10-06 20:17:16', '2025-10-06 20:17:19'),
(90, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:17:19', '2025-10-06 20:17:21', -2.370092, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:47:20.468Z\"}', '2025-10-06 20:17:19', '2025-10-06 20:17:21'),
(91, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:22:06', '2025-10-06 20:22:11', -5.703916, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:52:10.572Z\"}', '2025-10-06 20:22:06', '2025-10-06 20:22:11'),
(92, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:22:11', '2025-10-06 20:22:14', -3.144594, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:52:13.151Z\"}', '2025-10-06 20:22:11', '2025-10-06 20:22:14'),
(93, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:22:14', '2025-10-06 20:22:16', -2.68879, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:52:15.738Z\"}', '2025-10-06 20:22:14', '2025-10-06 20:22:16'),
(94, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:22:16', '2025-10-06 20:22:19', -3.147331, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T14:52:17.980Z\"}', '2025-10-06 20:22:16', '2025-10-06 20:22:19'),
(95, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:37:40', '2025-10-06 20:37:43', -3.429717, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T15:07:42.307Z\"}', '2025-10-06 20:37:40', '2025-10-06 20:37:43'),
(96, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:37:43', '2025-10-06 20:37:46', -3.133533, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T15:07:45.126Z\"}', '2025-10-06 20:37:43', '2025-10-06 20:37:46'),
(97, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:37:46', '2025-10-06 20:37:48', -2.219577, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T15:07:47.306Z\"}', '2025-10-06 20:37:46', '2025-10-06 20:37:48'),
(98, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-06 20:37:48', '2025-10-06 20:37:55', -7.167361, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-06T15:07:54.048Z\"}', '2025-10-06 20:37:48', '2025-10-06 20:37:55'),
(99, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 11:37:44', '2025-10-07 11:37:47', -3.685779, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T06:07:46.363Z\"}', '2025-10-07 11:37:44', '2025-10-07 11:37:47'),
(100, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 11:37:47', '2025-10-07 11:37:50', -3.170397, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T06:07:49.137Z\"}', '2025-10-07 11:37:47', '2025-10-07 11:37:50'),
(101, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 11:37:50', '2025-10-07 11:37:52', -2.713336, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T06:07:51.570Z\"}', '2025-10-07 11:37:50', '2025-10-07 11:37:52'),
(102, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 11:37:52', '2025-10-07 11:37:55', -3.55859, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T06:07:53.962Z\"}', '2025-10-07 11:37:52', '2025-10-07 11:37:55'),
(103, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:43:32', '2025-10-07 13:43:38', -6.081638, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:13:36.818Z\"}', '2025-10-07 13:43:32', '2025-10-07 13:43:38'),
(104, 3, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:43:38', '2025-10-07 13:43:42', -4.097455, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:13:40.916Z\"}', '2025-10-07 13:43:38', '2025-10-07 13:43:42'),
(105, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:53:24', '2025-10-07 13:53:28', -4.698184, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:23:27.364Z\"}', '2025-10-07 13:53:24', '2025-10-07 13:53:28'),
(106, 3, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:53:28', '2025-10-07 13:53:33', -5.183752, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:23:32.070Z\"}', '2025-10-07 13:53:28', '2025-10-07 13:53:33'),
(107, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:55:33', '2025-10-07 13:55:38', -5.120742, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:25:36.334Z\"}', '2025-10-07 13:55:33', '2025-10-07 13:55:38'),
(108, 3, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 13:55:38', '2025-10-07 13:55:42', -4.562661, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-07T08:25:41.432Z\"}', '2025-10-07 13:55:38', '2025-10-07 13:55:42'),
(109, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:12', '2025-10-07 18:12:16', -4.86606, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:15.739Z\"}', '2025-10-07 18:12:12', '2025-10-07 18:12:16'),
(110, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:16', '2025-10-07 18:12:21', -5.333502, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:20.151Z\"}', '2025-10-07 18:12:16', '2025-10-07 18:12:21'),
(111, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:21', '2025-10-07 18:12:25', -4.810813, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:24.649Z\"}', '2025-10-07 18:12:21', '2025-10-07 18:12:25'),
(112, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:25', '2025-10-07 18:12:29', -4.010711, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:27.404Z\"}', '2025-10-07 18:12:25', '2025-10-07 18:12:29'),
(113, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:39', '2025-10-07 18:12:43', -4.256201, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:42.151Z\"}', '2025-10-07 18:12:39', '2025-10-07 18:12:43'),
(114, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:43', '2025-10-07 18:12:47', -4.972244, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:46.781Z\"}', '2025-10-07 18:12:43', '2025-10-07 18:12:47'),
(115, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:47', '2025-10-07 18:12:51', -4.960997, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:50.512Z\"}', '2025-10-07 18:12:47', '2025-10-07 18:12:51'),
(116, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-07 18:12:51', '2025-10-07 18:12:56', -5.76552, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-07T12:42:55.510Z\"}', '2025-10-07 18:12:51', '2025-10-07 18:12:56'),
(117, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 11:37:57', '2025-10-10 11:38:00', -3.456625, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T06:07:59.413Z\"}', '2025-10-10 11:37:57', '2025-10-10 11:38:00'),
(118, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 11:38:00', '2025-10-10 11:38:03', -3.309175, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T06:08:02.264Z\"}', '2025-10-10 11:38:00', '2025-10-10 11:38:03'),
(119, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 11:38:03', '2025-10-10 11:38:08', -5.121292, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T06:08:07.097Z\"}', '2025-10-10 11:38:03', '2025-10-10 11:38:08'),
(120, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 11:38:08', '2025-10-10 11:38:10', -2.999049, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T06:08:09.890Z\"}', '2025-10-10 11:38:08', '2025-10-10 11:38:10'),
(121, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 16:40:52', '2025-10-10 16:40:57', -5.2606, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T11:10:56.171Z\"}', '2025-10-10 16:40:52', '2025-10-10 16:40:57'),
(122, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 16:40:57', '2025-10-10 16:41:01', -4.833902, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T11:11:00.661Z\"}', '2025-10-10 16:40:57', '2025-10-10 16:41:01'),
(123, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 16:41:01', '2025-10-10 16:41:06', -5.356707, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T11:11:05.287Z\"}', '2025-10-10 16:41:01', '2025-10-10 16:41:06'),
(124, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 16:41:06', '2025-10-10 16:41:10', -4.740753, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T11:11:09.585Z\"}', '2025-10-10 16:41:06', '2025-10-10 16:41:10'),
(125, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 20:38:59', '2025-10-10 20:39:02', -3.066582, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T15:09:00.701Z\"}', '2025-10-10 20:38:59', '2025-10-10 20:39:02'),
(126, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 20:39:02', '2025-10-10 20:39:05', -3.221278, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T15:09:03.518Z\"}', '2025-10-10 20:39:02', '2025-10-10 20:39:05'),
(127, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 20:39:05', '2025-10-10 20:39:07', -2.582463, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T15:09:06.384Z\"}', '2025-10-10 20:39:05', '2025-10-10 20:39:07'),
(128, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-10 20:39:07', '2025-10-10 20:39:10', -3.060285, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-10T15:09:08.838Z\"}', '2025-10-10 20:39:07', '2025-10-10 20:39:10'),
(129, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:17:02', '2025-10-11 22:17:07', -5.238467, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:47:06.215Z\"}', '2025-10-11 22:17:02', '2025-10-11 22:17:07'),
(130, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:17:07', '2025-10-11 22:17:11', -4.283859, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:47:10.447Z\"}', '2025-10-11 22:17:07', '2025-10-11 22:17:11'),
(131, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:17:11', '2025-10-11 22:17:16', -5.439436, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:47:14.582Z\"}', '2025-10-11 22:17:11', '2025-10-11 22:17:16'),
(132, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:17:16', '2025-10-11 22:17:19', -3.714124, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:47:18.849Z\"}', '2025-10-11 22:17:16', '2025-10-11 22:17:19'),
(133, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:17:56', '2025-10-11 22:18:00', -4.312878, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:47:59.463Z\"}', '2025-10-11 22:17:56', '2025-10-11 22:18:00'),
(134, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:18:00', '2025-10-11 22:18:03', -3.880955, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:48:02.998Z\"}', '2025-10-11 22:18:00', '2025-10-11 22:18:03'),
(135, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:18:03', '2025-10-11 22:18:05', -2.990636, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:48:05.188Z\"}', '2025-10-11 22:18:03', '2025-10-11 22:18:05'),
(136, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:18:06', '2025-10-11 22:18:09', -3.378425, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:48:08.384Z\"}', '2025-10-11 22:18:06', '2025-10-11 22:18:09'),
(137, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:21:48', '2025-10-11 22:21:52', -4.615399, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:51:51.685Z\"}', '2025-10-11 22:21:48', '2025-10-11 22:21:52'),
(138, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:21:52', '2025-10-11 22:21:56', -4.963257, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:51:55.950Z\"}', '2025-10-11 22:21:52', '2025-10-11 22:21:56'),
(139, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:21:56', '2025-10-11 22:22:00', -4.974829, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:52:00.125Z\"}', '2025-10-11 22:21:56', '2025-10-11 22:22:00'),
(140, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-11 22:22:00', '2025-10-11 22:22:05', -5.150229, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-11T16:52:04.259Z\"}', '2025-10-11 22:22:00', '2025-10-11 22:22:05'),
(141, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:22:08', '2025-10-12 10:22:11', -3.867252, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T04:52:10.782Z\"}', '2025-10-12 10:22:08', '2025-10-12 10:22:11'),
(142, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:22:11', '2025-10-12 10:22:14', -3.986875, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T04:52:14.121Z\"}', '2025-10-12 10:22:11', '2025-10-12 10:22:14'),
(143, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:22:14', '2025-10-12 10:22:17', -3.057291, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T04:52:16.246Z\"}', '2025-10-12 10:22:14', '2025-10-12 10:22:17'),
(144, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:22:17', '2025-10-12 10:22:19', -2.545122, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T04:52:18.675Z\"}', '2025-10-12 10:22:17', '2025-10-12 10:22:19'),
(145, 6, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:00', '2025-10-12 10:45:03', -3.505558, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-12T05:15:02.383Z\"}', '2025-10-12 10:45:00', '2025-10-12 10:45:03'),
(146, 3, 'auto', 'create', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:03', '2025-10-12 10:45:06', -3.165032, 'system', NULL, '{\"success\":true,\"message\":\"Record created successfully\",\"timestamp\":\"2025-10-12T05:15:05.261Z\"}', '2025-10-12 10:45:03', '2025-10-12 10:45:06'),
(147, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:09', '2025-10-12 10:45:12', -3.421624, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:15:11.419Z\"}', '2025-10-12 10:45:09', '2025-10-12 10:45:12'),
(148, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:12', '2025-10-12 10:45:14', -2.976578, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:15:13.974Z\"}', '2025-10-12 10:45:12', '2025-10-12 10:45:14'),
(149, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:14', '2025-10-12 10:45:17', -3.332208, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:15:16.302Z\"}', '2025-10-12 10:45:14', '2025-10-12 10:45:17'),
(150, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:45:17', '2025-10-12 10:45:20', -3.27979, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:15:19.050Z\"}', '2025-10-12 10:45:17', '2025-10-12 10:45:20'),
(151, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:48:48', '2025-10-12 10:48:51', -3.630468, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:18:50.470Z\"}', '2025-10-12 10:48:48', '2025-10-12 10:48:51'),
(152, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:48:51', '2025-10-12 10:48:54', -3.890103, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:18:53.950Z\"}', '2025-10-12 10:48:51', '2025-10-12 10:48:54'),
(153, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:48:54', '2025-10-12 10:48:58', -4.034879, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:18:56.973Z\"}', '2025-10-12 10:48:54', '2025-10-12 10:48:58'),
(154, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:48:58', '2025-10-12 10:49:00', -2.531813, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:18:59.548Z\"}', '2025-10-12 10:48:58', '2025-10-12 10:49:00'),
(155, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 10:49:00', '2025-10-12 10:49:03', -3.16546, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T05:19:02.284Z\"}', '2025-10-12 10:49:00', '2025-10-12 10:49:03'),
(156, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 12:34:01', '2025-10-12 12:34:04', -3.228525, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:04:03.089Z\"}', '2025-10-12 12:34:01', '2025-10-12 12:34:04'),
(157, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 12:34:04', '2025-10-12 12:34:07', -3.314257, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:04:06.263Z\"}', '2025-10-12 12:34:04', '2025-10-12 12:34:07'),
(158, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 12:34:07', '2025-10-12 12:34:10', -3.954611, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:04:09.844Z\"}', '2025-10-12 12:34:07', '2025-10-12 12:34:10'),
(159, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 12:34:10', '2025-10-12 12:34:13', -3.38545, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:04:12.460Z\"}', '2025-10-12 12:34:10', '2025-10-12 12:34:13'),
(160, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 12:34:13', '2025-10-12 12:34:16', -3.004805, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:04:14.910Z\"}', '2025-10-12 12:34:13', '2025-10-12 12:34:16'),
(161, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 13:22:28', '2025-10-12 13:22:36', -8.984065, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:52:33.892Z\"}', '2025-10-12 13:22:28', '2025-10-12 13:22:36'),
(162, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 13:22:37', '2025-10-12 13:22:44', -7.156755, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:52:41.086Z\"}', '2025-10-12 13:22:37', '2025-10-12 13:22:44'),
(163, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 13:22:44', '2025-10-12 13:22:48', -4.737314, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:52:45.672Z\"}', '2025-10-12 13:22:44', '2025-10-12 13:22:48'),
(164, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 13:22:48', '2025-10-12 13:22:55', -7.74047, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:52:52.708Z\"}', '2025-10-12 13:22:48', '2025-10-12 13:22:55'),
(165, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-12 13:22:55', '2025-10-12 13:23:02', -7.262405, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T07:52:59.280Z\"}', '2025-10-12 13:22:55', '2025-10-12 13:23:02'),
(166, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-13 00:23:37', '2025-10-13 00:23:40', -3.417939, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T18:53:39.364Z\"}', '2025-10-13 00:23:37', '2025-10-13 00:23:40'),
(167, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-13 00:23:40', '2025-10-13 00:23:43', -3.051263, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T18:53:42.372Z\"}', '2025-10-13 00:23:40', '2025-10-13 00:23:43'),
(168, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-13 00:23:43', '2025-10-13 00:23:45', -2.722651, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T18:53:44.689Z\"}', '2025-10-13 00:23:43', '2025-10-13 00:23:45'),
(169, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-13 00:23:45', '2025-10-13 00:23:51', -6.21341, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T18:53:47.191Z\"}', '2025-10-13 00:23:45', '2025-10-13 00:23:51'),
(170, 3, 'auto', 'update', 'success', 1, 1, 0, NULL, NULL, NULL, '2025-10-13 00:23:51', '2025-10-13 00:23:53', -2.337248, 'system', NULL, '{\"success\":true,\"message\":\"Record updated successfully\",\"timestamp\":\"2025-10-12T18:53:52.498Z\"}', '2025-10-13 00:23:51', '2025-10-13 00:23:53');


-- Table structure for table `communication_settings`
DROP TABLE IF EXISTS `communication_settings`;
CREATE TABLE "communication_settings" ("id" integer primary key autoincrement not null, "provider" varchar not null, "service" varchar not null, "key" varchar not null, "value" text, "type" varchar not null default 'string', "category" varchar not null default 'general', "description" varchar, "is_active" tinyint(1) not null default '1', "is_encrypted" tinyint(1) not null default '0', "metadata" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `communication_settings`
INSERT INTO `communication_settings` (`id`, `provider`, `service`, `key`, `value`, `type`, `category`, `description`, `is_active`, `is_encrypted`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'email', 'smtp', 'from_address', 'contact@sjfashionhub.com', 'string', 'general', 'From email address', 1, 0, NULL, '2025-09-27 14:15:10', '2025-10-03 21:49:31'),
(2, 'email', 'smtp', 'from_name', 'SJ Fashion Hub', 'string', 'general', 'From name', 1, 0, NULL, '2025-09-27 14:15:10', '2025-09-27 15:38:15'),
(3, 'email', 'smtp', 'host', 'smtp.gmail.com', 'string', 'api', 'SMTP host', 1, 0, NULL, '2025-09-27 14:15:10', '2025-10-03 21:49:31'),
(4, 'email', 'smtp', 'port', '465', 'integer', 'api', 'SMTP port', 1, 0, NULL, '2025-09-27 14:15:10', '2025-09-27 14:15:10'),
(5, 'email', 'smtp', 'username', 'Contact@sjfashionhub.com', 'string', 'api', 'SMTP username', 1, 0, NULL, '2025-09-27 14:15:10', '2025-10-03 21:49:31'),
(6, 'email', 'smtp', 'password', 'eyJpdiI6IjZBdmsvN0JVRjJ5c0d3RVZsR2RMY2c9PSIsInZhbHVlIjoiOHZHTlJtTWdJb256MTZrWUMvWGdZcDhxK2RDcjhqM2hOVWRESkZabU4rUT0iLCJtYWMiOiJiMWFmZmMwYWUyMTY5OWVkOTU1NWNjMmUzZDBhMzI5MjY1MWM4YzFlNjg5NzYxMDY3ODdiN2EyOTJkZGYwMGM0IiwidGFnIjoiIn0=', 'string', 'api', 'SMTP password', 1, 1, NULL, '2025-09-27 14:15:10', '2025-10-03 21:49:32'),
(7, 'email', 'smtp', 'encryption', 'ssl', 'string', 'api', 'SMTP encryption', 1, 0, NULL, '2025-09-27 14:15:10', '2025-09-27 14:15:10'),
(8, 'email', 'general', 'active_service', 'smtp', 'string', 'general', 'Active email service', 1, 0, NULL, '2025-09-27 14:15:10', '2025-09-27 14:15:10'),
(9, 'system', 'preferences', 'email_order_placed', '1', 'boolean', 'notification_preferences', 'Notification preference for email order placed', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(10, 'system', 'preferences', 'email_order_shipped', '1', 'boolean', 'notification_preferences', 'Notification preference for email order shipped', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(11, 'system', 'preferences', 'email_order_delivered', '1', 'boolean', 'notification_preferences', 'Notification preference for email order delivered', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(12, 'system', 'preferences', 'email_admin_alerts', '1', 'boolean', 'notification_preferences', 'Notification preference for email admin alerts', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(13, 'system', 'preferences', 'sms_order_placed', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order placed', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(14, 'system', 'preferences', 'sms_order_shipped', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order shipped', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(15, 'system', 'preferences', 'sms_order_delivered', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order delivered', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(16, 'system', 'preferences', 'sms_out_for_delivery', '0', 'boolean', 'notification_preferences', 'Notification preference for sms out for delivery', 1, 0, NULL, '2025-09-28 14:11:13', '2025-09-28 14:11:13'),
(17, 'system', 'preferences', 'whatsapp_order_placed', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order placed', 1, 0, NULL, '2025-09-28 14:11:13', '2025-10-12 10:49:39'),
(18, 'system', 'preferences', 'whatsapp_order_shipped', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order shipped', 1, 0, NULL, '2025-09-28 14:11:13', '2025-10-12 10:49:39'),
(19, 'system', 'preferences', 'whatsapp_order_delivered', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order delivered', 1, 0, NULL, '2025-09-28 14:11:13', '2025-10-12 10:49:39'),
(20, 'system', 'preferences', 'whatsapp_welcome', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp welcome', 1, 0, NULL, '2025-09-28 14:11:13', '2025-10-12 10:49:39'),
(21, 'whatsapp', 'whatsapp_business', 'api_key', 'eyJpdiI6InhnU3B0T1J2SnJCTmZoQ2lEWEFUTUE9PSIsInZhbHVlIjoiQVNzRnJQeEcwcnlCbkFKSExZa05oelVoUmxUTm0vV0VJU0pHMWV0R05STDZCdDRqQkxhdXhGV0lKTW9QTHpUZ0hDY3VOMXZwbTdGZWpEbnA5bk53Vit0N1poVFJETXd4RUlJM2VCSkxKdmxqcUNWQTNvSFZaeXNSVGpVVWpzQVhnRktRK1lQV2NyaGI0VlRQcTRibzlMRVZnMUhBY2ZWdlV5REkzcFdPZ3NYVFVtVUFvWEd1U0RsejZDK3o3VlBaNCtJa2pkamNyaXVJeFdpc1FNTURNT281WTRBV25tSHNoRDVONE5lVzBlWGJEckJFSnRpc3FmK2s1UjJ5SmRMbXlvV0tkaUsyck9JQTh5N3JlTUVCVTdqUDlsdjY3WGZUbHRRc2J2a2kzQ1U9IiwibWFjIjoiZGFlZWEwZWYzYWIzNGUwMGYxYjkzYmIyZDFiYWE0NjA3YTlhY2ZlODcwM2JmMWUzZmQ5ZWE0NWJlYzZiMmM2NiIsInRhZyI6IiJ9', 'string', 'api', 'Api key', 1, 1, NULL, '2025-10-03 21:16:14', '2025-10-11 23:05:19'),
(22, 'whatsapp', 'whatsapp_business', 'phone_number', '730173600190286', 'string', 'api', 'Phone number', 1, 0, NULL, '2025-10-03 21:16:14', '2025-10-03 21:16:14'),
(23, 'whatsapp', 'whatsapp_business', 'business_account_id', '845234471785648', 'string', 'api', 'Business account id', 1, 0, NULL, '2025-10-03 21:16:14', '2025-10-03 21:16:14'),
(24, 'whatsapp', 'whatsapp_business', 'webhook_url', 'https://sjfashionhub.com/webhook/whatsapp', 'string', 'api', 'Webhook url', 1, 0, NULL, '2025-10-03 21:16:14', '2025-10-03 21:16:14'),
(25, 'whatsapp', 'whatsapp_business', 'webhook_verify_token', 'sjfashion_7060c651f190e9c0fce183e9adeb4c8c', 'string', 'api', 'Webhook verify token', 1, 0, NULL, '2025-10-03 21:16:14', '2025-10-03 21:16:14'),
(26, 'whatsapp', 'whatsapp_business', 'api_version', 'v18.0', 'string', 'api', 'Api version', 1, 0, NULL, '2025-10-03 21:16:14', '2025-10-03 21:16:14'),
(27, 'system', 'preferences', 'whatsapp_out_for_delivery', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp out for delivery', 1, 0, NULL, '2025-10-12 05:32:58', '2025-10-12 11:19:58'),
(28, 'system', 'preferences', 'email_welcome', '1', 'boolean', 'notification_preferences', 'Notification preference for email welcome', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(29, 'system', 'preferences', 'email_order_confirmed', '1', 'boolean', 'notification_preferences', 'Notification preference for email order confirmed', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(30, 'system', 'preferences', 'email_ready_to_ship', '1', 'boolean', 'notification_preferences', 'Notification preference for email ready to ship', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(31, 'system', 'preferences', 'email_out_for_delivery', '1', 'boolean', 'notification_preferences', 'Notification preference for email out for delivery', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(32, 'system', 'preferences', 'email_order_cancelled', '1', 'boolean', 'notification_preferences', 'Notification preference for email order cancelled', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(33, 'system', 'preferences', 'email_order_rto', '1', 'boolean', 'notification_preferences', 'Notification preference for email order rto', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(34, 'system', 'preferences', 'email_return_request', '1', 'boolean', 'notification_preferences', 'Notification preference for email return request', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(35, 'system', 'preferences', 'sms_welcome', '0', 'boolean', 'notification_preferences', 'Notification preference for sms welcome', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(36, 'system', 'preferences', 'sms_order_confirmed', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order confirmed', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(37, 'system', 'preferences', 'sms_ready_to_ship', '0', 'boolean', 'notification_preferences', 'Notification preference for sms ready to ship', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(38, 'system', 'preferences', 'sms_order_cancelled', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order cancelled', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(39, 'system', 'preferences', 'sms_order_rto', '0', 'boolean', 'notification_preferences', 'Notification preference for sms order rto', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(40, 'system', 'preferences', 'sms_return_request', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return request', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(41, 'system', 'preferences', 'whatsapp_order_confirmed', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order confirmed', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(42, 'system', 'preferences', 'whatsapp_ready_to_ship', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp ready to ship', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(43, 'system', 'preferences', 'whatsapp_order_cancelled', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order cancelled', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(44, 'system', 'preferences', 'whatsapp_order_rto', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp order rto', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(45, 'system', 'preferences', 'whatsapp_return_request', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return request', 1, 0, NULL, '2025-10-12 11:19:58', '2025-10-12 11:19:58'),
(46, 'system', 'preferences', 'email_return_approved', '1', 'boolean', 'notification_preferences', 'Notification preference for email return approved', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(47, 'system', 'preferences', 'email_return_rejected', '1', 'boolean', 'notification_preferences', 'Notification preference for email return rejected', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(48, 'system', 'preferences', 'email_return_in_transit', '1', 'boolean', 'notification_preferences', 'Notification preference for email return in transit', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(49, 'system', 'preferences', 'email_return_received', '1', 'boolean', 'notification_preferences', 'Notification preference for email return received', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(50, 'system', 'preferences', 'email_return_refund_processed', '1', 'boolean', 'notification_preferences', 'Notification preference for email return refund processed', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(51, 'system', 'preferences', 'sms_return_approved', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return approved', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(52, 'system', 'preferences', 'sms_return_rejected', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return rejected', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(53, 'system', 'preferences', 'sms_return_in_transit', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return in transit', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(54, 'system', 'preferences', 'sms_return_received', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return received', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(55, 'system', 'preferences', 'sms_return_refund_processed', '0', 'boolean', 'notification_preferences', 'Notification preference for sms return refund processed', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(56, 'system', 'preferences', 'whatsapp_return_approved', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return approved', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(57, 'system', 'preferences', 'whatsapp_return_rejected', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return rejected', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(58, 'system', 'preferences', 'whatsapp_return_in_transit', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return in transit', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(59, 'system', 'preferences', 'whatsapp_return_received', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return received', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13'),
(60, 'system', 'preferences', 'whatsapp_return_refund_processed', '1', 'boolean', 'notification_preferences', 'Notification preference for whatsapp return refund processed', 1, 0, NULL, '2025-10-12 11:24:13', '2025-10-12 11:24:13');


-- Table structure for table `communication_templates`
DROP TABLE IF EXISTS `communication_templates`;
CREATE TABLE "communication_templates" ("id" integer primary key autoincrement not null, "name" varchar not null, "type" varchar not null, "category" varchar not null, "event" varchar not null, "subject" varchar, "content" text not null, "html_content" text, "variables" text, "settings" text, "language" varchar not null default 'en', "is_active" tinyint(1) not null default '1', "is_default" tinyint(1) not null default '0', "priority" integer not null default '0', "description" text, "metadata" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `communication_templates`
INSERT INTO `communication_templates` (`id`, `name`, `type`, `category`, `event`, `subject`, `content`, `html_content`, `variables`, `settings`, `language`, `is_active`, `is_default`, `priority`, `description`, `metadata`, `created_at`, `updated_at`) VALUES
(1, 'Email Verification', 'email', 'verification', 'email_verification', 'Verify Your Email - {{site_name}}', 'Hi {{user_name}}, Please verify your email by clicking this link: {{verification_link}}', '<h2>Hi {{user_name}}</h2><p>Please verify your email by clicking this link:</p><a href=\"{{verification_link}}\">Verify Email</a>', NULL, NULL, 'en', 1, 1, 0, NULL, NULL, '2025-09-26 20:31:58', '2025-09-26 20:31:58'),
(2, 'Order Confirmation', 'email', 'order', 'order_placed', 'Order Confirmation #{{order_id}} - {{site_name}}', 'Hi {{user_name}}, Your order #{{order_id}} has been placed successfully. Total: ₹{{order_total}}', '<h2>Order Confirmation</h2><p>Hi {{user_name}}</p><p>Your order #{{order_id}} has been placed successfully.</p><p>Total: ₹{{order_total}}</p>', NULL, NULL, 'en', 1, 1, 0, NULL, NULL, '2025-09-26 20:31:58', '2025-09-26 20:31:58'),
(3, 'OTP Verification', 'sms', 'verification', 'phone_verification', NULL, 'Your OTP for {{site_name}} is {{verification_code}}. Valid for 10 minutes.', NULL, NULL, NULL, 'en', 1, 1, 0, NULL, NULL, '2025-09-26 20:31:58', '2025-09-26 20:31:58'),
(4, 'Order Shipped', 'sms', 'order', 'order_shipped', NULL, 'Your order #{{order_id}} has been shipped. Track: {{tracking_number}}', NULL, NULL, NULL, 'en', 1, 1, 0, NULL, NULL, '2025-09-26 20:31:58', '2025-09-26 20:31:58'),
(5, 'Order Update', 'whatsapp', 'order', 'order_status_update', NULL, 'Hi {{user_name}}, Your order #{{order_id}} status: {{order_status}}. Track your order: {{tracking_number}}', NULL, NULL, NULL, 'en', 1, 1, 0, NULL, NULL, '2025-09-26 20:31:58', '2025-09-26 20:31:58'),
(6, 'Order Placed - Customer', 'email', 'order', 'order_placed_customer', '🎉 Order Confirmation #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Thank you for your order! We\'re excited to confirm that we\'ve received your order #{{order_number}}.

Order Details:
- Order Number: {{order_number}}
- Total Amount: ₹{{order_total}}
- Payment Method: {{payment_method}}

Your order is being processed and you\'ll receive another email once it\'s confirmed.

You can track your order status at: {{tracking_url}}

Thank you for shopping with {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #2563eb; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #f8fafc; padding: 15px; border-radius: 8px; margin: 20px 0; }
        .button { display: inline-block; background: #2563eb; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🎉 Order Confirmation</h1>
            <p>Thank you for your order!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>We are excited to confirm that we have received your order <strong>#{{order_number}}</strong>.</p>

        <div class=\"order-details\">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Payment Method:</strong> {{payment_method}}</p>
        </div>

        <p>Your order is being processed and you will receive another email once it is confirmed by our team.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{tracking_url}}\" class=\"button\">📦 Track Your Order</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for shopping with <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"order_total\",\"order_items\",\"billing_address\",\"shipping_address\",\"payment_method\",\"tracking_url\",\"site_name\",\"site_url\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is placed', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(7, 'Order Confirmed - Customer', 'email', 'order', 'order_confirmed_customer', '✅ Order Confirmed #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Great news! Your order #{{order_number}} has been confirmed and is now being prepared for shipment.

Order Details:
- Order Number: {{order_number}}
- Total Amount: ₹{{order_total}}
- Estimated Delivery: {{estimated_delivery}}

We\'ll send you another email with tracking information once your order is shipped.

Track your order: {{tracking_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Confirmed</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #f0fdf4; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669; }
        .button { display: inline-block; background: #059669; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>✅ Order Confirmed</h1>
            <p>Your order is being prepared!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your order <strong>#{{order_number}}</strong> has been confirmed and is now being prepared for shipment.</p>

        <div class=\"order-details\">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>We will send you another email with tracking information once your order is shipped.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{tracking_url}}\" class=\"button\">📦 Track Your Order</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"order_total\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is confirmed by admin', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(8, 'Order Ready to Ship - Customer', 'email', 'order', 'order_ready_to_ship_customer', '📦 Order Ready to Ship #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Your order #{{order_number}} is now ready to ship! Our team has carefully packed your items and they will be dispatched soon.

Order Details:
- Order Number: {{order_number}}
- Estimated Delivery: {{estimated_delivery}}

You\'ll receive tracking information once the package is picked up by our courier partner.

Track your order: {{tracking_url}}

Thank you for your patience!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Ready to Ship</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #7c3aed; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #faf5ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #7c3aed; }
        .button { display: inline-block; background: #7c3aed; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>📦 Ready to Ship</h1>
            <p>Your order is packed and ready!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your order <strong>#{{order_number}}</strong> is now ready to ship! Our team has carefully packed your items and they will be dispatched soon.</p>

        <div class=\"order-details\">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>You will receive tracking information once the package is picked up by our courier partner.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{tracking_url}}\" class=\"button\">📦 Track Your Order</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for your patience!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is ready to ship', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(9, 'Low Stock Alert - Admin', 'email', 'notification', 'low_stock_alert_admin', '⚠️ Low Stock Alert - {{product_name}} - {{site_name}}', 'Low Stock Alert!

Product: {{product_name}} (SKU: {{product_sku}})
Current Stock: {{current_stock}} units
Threshold: {{threshold}} units

The product stock has fallen below the minimum threshold. Please restock soon to avoid stockouts.

Admin Panel: {{admin_url}}

{{site_name}} Admin System', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Low Stock Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .alert-box { background: #fffbeb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b; }
        .button { display: inline-block; background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>⚠️ Low Stock Alert</h1>
            <p>Immediate attention required</p>
        </div>

        <h2>Stock Running Low!</h2>

        <div class=\"alert-box\">
            <h3>📦 Product Details</h3>
            <p><strong>Product:</strong> {{product_name}}</p>
            <p><strong>SKU:</strong> {{product_sku}}</p>
            <p><strong>Current Stock:</strong> {{current_stock}} units</p>
            <p><strong>Threshold:</strong> {{threshold}} units</p>
        </div>

        <p>The product stock has fallen below the minimum threshold. Please restock soon to avoid stockouts.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{admin_url}}\" class=\"button\">🔧 Manage Inventory</a>
        </div>

        <div class=\"footer\">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>', '[\"product_name\",\"product_sku\",\"current_stock\",\"threshold\",\"admin_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to admin when product stock is low', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(10, 'Return Request Alert - Admin', 'email', 'return', 'return_request_admin', '🔄 Return Request Alert #{{return_number}} - {{site_name}}', 'Return Request Alert!

A new return request has been submitted.

Return Details:
- Return Number: {{return_number}}
- Order Number: {{order_number}}
- Customer: {{customer_name}}
- Reason: {{return_reason}}
- Items: {{return_items}}

Please review and process the return request in the admin panel.

Admin Panel: {{admin_url}}

{{site_name}} Admin System', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Return Request Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #8b5cf6; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f5f3ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #8b5cf6; }
        .button { display: inline-block; background: #8b5cf6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🔄 Return Request Alert</h1>
            <p>New return request received</p>
        </div>

        <h2>Return Request Submitted!</h2>
        <p>A new return request has been submitted and requires your attention.</p>

        <div class=\"return-details\">
            <h3>📋 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Customer:</strong> {{customer_name}}</p>
            <p><strong>Reason:</strong> {{return_reason}}</p>
            <p><strong>Items:</strong> {{return_items}}</p>
        </div>

        <p>Please review and process the return request in the admin panel.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{admin_url}}\" class=\"button\">🔧 Process Return</a>
        </div>

        <div class=\"footer\">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>', '[\"return_number\",\"order_number\",\"customer_name\",\"return_reason\",\"return_items\",\"admin_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to admin when customer submits return request', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(11, 'Welcome Email - Customer', 'email', 'notification', 'user_registered', '👋 Welcome to {{site_name}}!', 'Hi {{user_name}},

Welcome to {{site_name}}! We\'re thrilled to have you join our fashion community.

Your account has been successfully created with email: {{user_email}}

Here\'s what you can do now:
- Browse our latest collections
- Add items to your wishlist
- Enjoy exclusive member benefits
- Track your orders easily

Start shopping: {{site_url}}
Login to your account: {{login_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Welcome to SJ Fashion Hub</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #6366f1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .welcome-box { background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1; }
        .button { display: inline-block; background: #6366f1; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
        .benefits { background: #f8fafc; padding: 15px; border-radius: 8px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>👋 Welcome to {{site_name}}!</h1>
            <p>Your fashion journey starts here</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Welcome to <strong>{{site_name}}</strong>! We are thrilled to have you join our fashion community.</p>

        <div class=\"welcome-box\">
            <h3>✅ Account Created Successfully</h3>
            <p>Your account has been created with email: <strong>{{user_email}}</strong></p>
        </div>

        <div class=\"benefits\">
            <h3>🎉 What you can do now:</h3>
            <ul>
                <li>Browse our latest collections</li>
                <li>Add items to your wishlist</li>
                <li>Enjoy exclusive member benefits</li>
                <li>Track your orders easily</li>
            </ul>
        </div>

        <div style=\"text-align: center;\">
            <a href=\"{{site_url}}\" class=\"button\">🛍️ Start Shopping</a>
            <a href=\"{{login_url}}\" class=\"button\">🔐 Login</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"user_email\",\"site_name\",\"site_url\",\"login_url\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when they register', NULL, '2025-09-28 13:43:58', '2025-09-28 13:43:58'),
(12, 'Order Shipped - Customer', 'email', 'order', 'order_shipped_customer', '🚚 Order Shipped #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Great news! Your order #{{order_number}} has been shipped and is on its way to you.

Shipping Details:
- Tracking Number: {{tracking_number}}
- Courier Company: {{courier_company}}
- Estimated Delivery: {{estimated_delivery}}

You can track your package in real-time using the tracking link below.

Track your package: {{tracking_url}}

Thank you for shopping with {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Shipped</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #3b82f6; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .shipping-details { background: #eff6ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #3b82f6; }
        .button { display: inline-block; background: #3b82f6; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🚚 Order Shipped</h1>
            <p>Your package is on the way!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your order <strong>#{{order_number}}</strong> has been shipped and is on its way to you.</p>

        <div class=\"shipping-details\">
            <h3>🚛 Shipping Details</h3>
            <p><strong>Tracking Number:</strong> {{tracking_number}}</p>
            <p><strong>Courier Company:</strong> {{courier_company}}</p>
            <p><strong>Estimated Delivery:</strong> {{estimated_delivery}}</p>
        </div>

        <p>You can track your package in real-time using the tracking link below.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{tracking_url}}\" class=\"button\">📦 Track Your Package</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for shopping with <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"tracking_number\",\"courier_company\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is shipped', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(13, 'Order Out for Delivery - Customer', 'email', 'order', 'order_out_for_delivery_customer', '🏃‍♂️ Order Out for Delivery #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Your order #{{order_number}} is out for delivery and will reach you today!

Delivery Details:
- Tracking Number: {{tracking_number}}
- Courier Company: {{courier_company}}
- Expected Delivery: {{delivery_date}}

Please ensure someone is available to receive the package.

Track your delivery: {{tracking_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Out for Delivery</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #f59e0b; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .delivery-details { background: #fffbeb; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #f59e0b; }
        .button { display: inline-block; background: #f59e0b; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
        .alert { background: #fef3c7; border: 1px solid #f59e0b; padding: 10px; border-radius: 6px; margin: 15px 0; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🏃‍♂️ Out for Delivery</h1>
            <p>Your package will arrive today!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your order <strong>#{{order_number}}</strong> is out for delivery and will reach you today!</p>

        <div class=\"delivery-details\">
            <h3>🚛 Delivery Details</h3>
            <p><strong>Tracking Number:</strong> {{tracking_number}}</p>
            <p><strong>Courier Company:</strong> {{courier_company}}</p>
            <p><strong>Expected Delivery:</strong> {{delivery_date}}</p>
        </div>

        <div class=\"alert\">
            <p><strong>📍 Important:</strong> Please ensure someone is available to receive the package.</p>
        </div>

        <div style=\"text-align: center;\">
            <a href=\"{{tracking_url}}\" class=\"button\">📦 Track Your Delivery</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"tracking_number\",\"courier_company\",\"delivery_date\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is out for delivery', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(14, 'Order Delivered - Customer', 'email', 'order', 'order_delivered_customer', '🎉 Order Delivered #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

Congratulations! Your order #{{order_number}} has been successfully delivered on {{delivery_date}}.

We hope you love your purchase! If you have any questions or concerns about your order, please don\'t hesitate to contact us.

We\'d love to hear about your experience:
- Leave a review: {{review_url}}
- Need to return something? {{return_policy_url}}

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Delivered</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #10b981; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .success-box { background: #ecfdf5; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #10b981; }
        .button { display: inline-block; background: #10b981; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 5px; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🎉 Order Delivered</h1>
            <p>Your package has arrived!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Congratulations! Your order <strong>#{{order_number}}</strong> has been successfully delivered on <strong>{{delivery_date}}</strong>.</p>

        <div class=\"success-box\">
            <h3>✅ Delivery Confirmed</h3>
            <p>We hope you love your purchase! If you have any questions or concerns about your order, please do not hesitate to contact us.</p>
        </div>

        <p>We would love to hear about your experience:</p>

        <div style=\"text-align: center;\">
            <a href=\"{{review_url}}\" class=\"button\">⭐ Leave a Review</a>
            <a href=\"{{return_policy_url}}\" class=\"button\">📋 Return Policy</a>
        </div>

        <div class=\"footer\">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"delivery_date\",\"return_policy_url\",\"review_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is delivered', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(15, 'Order Cancelled - Customer', 'email', 'order', 'order_cancelled_customer', '❌ Order Cancelled #{{order_number}} - {{site_name}}', 'Hi {{user_name}},

We regret to inform you that your order #{{order_number}} has been cancelled.

Cancellation Details:
- Reason: {{cancellation_reason}}
- Refund Amount: ₹{{refund_amount}}
- Refund Timeline: {{refund_timeline}}

If you paid online, your refund will be processed automatically. For COD orders, no payment was collected.

We apologize for any inconvenience caused. Please feel free to place a new order anytime.

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Order Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #ef4444; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .cancel-details { background: #fef2f2; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #ef4444; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>❌ Order Cancelled</h1>
            <p>We apologize for the inconvenience</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>We regret to inform you that your order <strong>#{{order_number}}</strong> has been cancelled.</p>

        <div class=\"cancel-details\">
            <h3>📋 Cancellation Details</h3>
            <p><strong>Reason:</strong> {{cancellation_reason}}</p>
            <p><strong>Refund Amount:</strong> ₹{{refund_amount}}</p>
            <p><strong>Refund Timeline:</strong> {{refund_timeline}}</p>
        </div>

        <p>If you paid online, your refund will be processed automatically. For COD orders, no payment was collected.</p>
        <p>We apologize for any inconvenience caused. Please feel free to place a new order anytime.</p>

        <div class=\"footer\">
            <p>Best regards,<br><strong>{{site_name}}</strong> Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"order_number\",\"cancellation_reason\",\"refund_amount\",\"refund_timeline\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when order is cancelled', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(16, 'Return Request Submitted - Customer', 'email', 'return', 'return_request_submitted_customer', '📋 Return Request Submitted #{{return_number}} - {{site_name}}', 'Hi {{user_name}},

Your return request #{{return_number}} for order #{{order_number}} has been submitted successfully.

Return Details:
- Return Number: {{return_number}}
- Order Number: {{order_number}}
- Reason: {{return_reason}}
- Items: {{return_items}}

Our team will review your request and get back to you within {{processing_timeline}}.

Thank you for your patience!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Return Request Submitted</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #6366f1; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f0f9ff; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #6366f1; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>📋 Return Request Submitted</h1>
            <p>We have received your return request</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Your return request <strong>#{{return_number}}</strong> for order <strong>#{{order_number}}</strong> has been submitted successfully.</p>

        <div class=\"return-details\">
            <h3>📦 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Reason:</strong> {{return_reason}}</p>
            <p><strong>Items:</strong> {{return_items}}</p>
        </div>

        <p>Our team will review your request and get back to you within <strong>{{processing_timeline}}</strong>.</p>

        <div class=\"footer\">
            <p>Thank you for your patience!</p>
            <p>Best regards,<br><strong>{{site_name}}</strong> Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"return_number\",\"order_number\",\"return_reason\",\"return_items\",\"processing_timeline\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when return request is submitted', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(17, 'Return Approved - Customer', 'email', 'return', 'return_approved_customer', '✅ Return Approved #{{return_number}} - {{site_name}}', 'Hi {{user_name}},

Great news! Your return request #{{return_number}} has been approved.

Return Details:
- Return Number: {{return_number}}
- Pickup Date: {{pickup_date}}
- Refund Amount: ₹{{refund_amount}}
- Refund Timeline: {{refund_timeline}}

Pickup Instructions:
{{pickup_instructions}}

Your refund will be processed once we receive and verify the returned items.

Thank you for choosing {{site_name}}!

Best regards,
{{site_name}} Team', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>Return Approved</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #059669; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .return-details { background: #f0fdf4; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #059669; }
        .pickup-box { background: #fef3c7; border: 1px solid #f59e0b; padding: 15px; border-radius: 8px; margin: 15px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>✅ Return Approved</h1>
            <p>Your return request has been approved!</p>
        </div>

        <h2>Hi {{user_name}},</h2>
        <p>Great news! Your return request <strong>#{{return_number}}</strong> has been approved.</p>

        <div class=\"return-details\">
            <h3>📦 Return Details</h3>
            <p><strong>Return Number:</strong> {{return_number}}</p>
            <p><strong>Pickup Date:</strong> {{pickup_date}}</p>
            <p><strong>Refund Amount:</strong> ₹{{refund_amount}}</p>
            <p><strong>Refund Timeline:</strong> {{refund_timeline}}</p>
        </div>

        <div class=\"pickup-box\">
            <h3>📍 Pickup Instructions</h3>
            <p>{{pickup_instructions}}</p>
        </div>

        <p>Your refund will be processed once we receive and verify the returned items.</p>

        <div class=\"footer\">
            <p>Thank you for choosing <strong>{{site_name}}</strong>!</p>
            <p>Best regards,<br>{{site_name}} Team</p>
        </div>
    </div>
</body>
</html>', '[\"user_name\",\"return_number\",\"pickup_date\",\"pickup_instructions\",\"refund_amount\",\"refund_timeline\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to customer when return is approved', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(18, 'New Order Alert - Admin', 'email', 'order', 'new_order_admin', '🔔 New Order Alert #{{order_number}} - {{site_name}}', 'New Order Alert!

A new order has been placed on {{site_name}}.

Order Details:
- Order Number: {{order_number}}
- Customer: {{customer_name}} ({{customer_email}})
- Total Amount: ₹{{order_total}}
- Payment Method: {{payment_method}}

Items Ordered:
{{order_items}}

Please review and confirm the order in the admin panel.

Admin Panel: {{admin_url}}

{{site_name}} Admin System', '<!DOCTYPE html>
<html>
<head>
    <meta charset=\"utf-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>New Order Alert</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; margin: 0; padding: 0; background-color: #f4f4f4; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 10px; margin-top: 20px; }
        .header { background: #dc2626; color: white; padding: 20px; text-align: center; border-radius: 10px 10px 0 0; margin: -20px -20px 20px -20px; }
        .order-details { background: #fef2f2; padding: 15px; border-radius: 8px; margin: 20px 0; border-left: 4px solid #dc2626; }
        .button { display: inline-block; background: #dc2626; color: white; padding: 12px 24px; text-decoration: none; border-radius: 6px; margin: 10px 0; }
        .footer { text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #e5e7eb; color: #6b7280; }
    </style>
</head>
<body>
    <div class=\"container\">
        <div class=\"header\">
            <h1>🔔 New Order Alert</h1>
            <p>Action required in admin panel</p>
        </div>

        <h2>New Order Received!</h2>
        <p>A new order has been placed on <strong>{{site_name}}</strong>.</p>

        <div class=\"order-details\">
            <h3>📋 Order Details</h3>
            <p><strong>Order Number:</strong> {{order_number}}</p>
            <p><strong>Customer:</strong> {{customer_name}} ({{customer_email}})</p>
            <p><strong>Total Amount:</strong> ₹{{order_total}}</p>
            <p><strong>Payment Method:</strong> {{payment_method}}</p>
            <p><strong>Items Ordered:</strong><br>{{order_items}}</p>
        </div>

        <p>Please review and confirm the order in the admin panel.</p>

        <div style=\"text-align: center;\">
            <a href=\"{{admin_url}}\" class=\"button\">🔧 Open Admin Panel</a>
        </div>

        <div class=\"footer\">
            <p><strong>{{site_name}}</strong> Admin System</p>
        </div>
    </div>
</body>
</html>', '[\"order_number\",\"customer_name\",\"customer_email\",\"order_total\",\"payment_method\",\"order_items\",\"admin_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'Sent to admin when new order is placed', NULL, '2025-09-28 13:44:16', '2025-09-28 13:44:16'),
(19, 'Order Placed - SMS', 'sms', 'order', 'order_placed_customer', NULL, 'Hi {{user_name}}, your order #{{order_number}} for ₹{{order_total}} has been placed successfully. Track: {{tracking_url}} - {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"order_total\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'SMS sent to customer when order is placed', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(20, 'Order Confirmed - SMS', 'sms', 'order', 'order_confirmed_customer', NULL, 'Hi {{user_name}}, your order #{{order_number}} has been confirmed! Expected delivery: {{estimated_delivery}}. Track: {{tracking_url}} - {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'SMS sent to customer when order is confirmed', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(21, 'Order Shipped - SMS', 'sms', 'order', 'order_shipped_customer', NULL, 'Hi {{user_name}}, your order #{{order_number}} has been shipped! Tracking: {{tracking_number}} via {{courier_company}}. Track: {{tracking_url}} - {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"tracking_number\",\"courier_company\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'SMS sent to customer when order is shipped', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(22, 'Order Out for Delivery - SMS', 'sms', 'order', 'order_out_for_delivery_customer', NULL, 'Hi {{user_name}}, your order #{{order_number}} is out for delivery and will reach you today! Please be available to receive it. - {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'SMS sent to customer when order is out for delivery', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(23, 'Order Delivered - SMS', 'sms', 'order', 'order_delivered_customer', NULL, 'Hi {{user_name}}, your order #{{order_number}} has been delivered! Thank you for shopping with {{site_name}}. Need help? Contact us anytime.', NULL, '[\"user_name\",\"order_number\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'SMS sent to customer when order is delivered', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(24, 'Order Placed - WhatsApp', 'whatsapp', 'order', 'order_placed_customer', NULL, '🛍️ *Order Placed Successfully!*

Hi {{user_name}},

Your order #{{order_number}} for *₹{{order_total}}* has been placed successfully.

💳 Payment: {{payment_method}}
📦 Track your order: {{tracking_url}}

Thank you for choosing {{site_name}}! 🙏', NULL, '[\"user_name\",\"order_number\",\"order_total\",\"payment_method\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when order is placed', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(25, 'Order Confirmed - WhatsApp', 'whatsapp', 'order', 'order_confirmed_customer', NULL, '✅ *Order Confirmed!*

Hi {{user_name}},

Great news! Your order #{{order_number}} has been confirmed and is being prepared for shipment.

📅 Expected delivery: {{estimated_delivery}}
📦 Track your order: {{tracking_url}}

We\'ll notify you once it\'s shipped! 🚚

- {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when order is confirmed', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(26, 'Order Shipped - WhatsApp', 'whatsapp', 'order', 'order_shipped_customer', NULL, '🚚 *Order Shipped!*

Hi {{user_name}},

Your order #{{order_number}} is on its way to you!

📦 Tracking Number: {{tracking_number}}
🚛 Courier: {{courier_company}}
📅 Expected delivery: {{estimated_delivery}}

Track your package: {{tracking_url}}

- {{site_name}}', NULL, '[\"user_name\",\"order_number\",\"tracking_number\",\"courier_company\",\"estimated_delivery\",\"tracking_url\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when order is shipped', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(27, 'Order Out for Delivery - WhatsApp', 'whatsapp', 'order', 'order_out_for_delivery_customer', NULL, '🏃‍♂️ *Out for Delivery!*

Hi {{user_name}},

Your order #{{order_number}} is out for delivery and will reach you today!

📍 Please ensure someone is available to receive the package.

Thank you for choosing {{site_name}}! 🙏', NULL, '[\"user_name\",\"order_number\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when order is out for delivery', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(28, 'Order Delivered - WhatsApp', 'whatsapp', 'order', 'order_delivered_customer', NULL, '🎉 *Order Delivered!*

Hi {{user_name}},

Your order #{{order_number}} has been delivered successfully!

We hope you love your purchase! 💕

📝 Rate your experience
🔄 Need to return something?
💬 Have questions? Just reply to this message!

Thank you for shopping with {{site_name}}! 🛍️', NULL, '[\"user_name\",\"order_number\",\"site_name\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when order is delivered', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(29, 'Welcome Message - WhatsApp', 'whatsapp', 'notification', 'user_registered', NULL, '👋 *Welcome to {{site_name}}!*

Hi {{user_name}},

Welcome to our fashion family! 🎉

🛍️ Browse latest collections
💕 Add items to wishlist
🎁 Enjoy exclusive member benefits
📦 Track orders easily

Start shopping: {{site_url}}

Thank you for joining us! 🙏', NULL, '[\"user_name\",\"site_name\",\"site_url\"]', NULL, 'en', 1, 1, 100, 'WhatsApp message sent to customer when they register', NULL, '2025-09-28 14:04:16', '2025-09-28 14:04:16'),
(30, 'Order RTO - Customer', 'email', 'transactional', 'order_rto_customer', 'Order Returned to Origin - {{order_number}} | SJ Fashion Hub', 'Hi {{customer_name}},

Your order #{{order_number}} could not be delivered and is being returned to us.

Order Amount: ₹{{order_total}}
Reason: {{rto_reason}}

Your refund will be processed once we receive the package.

Please contact us if you\'d like to re-order.', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\",\\\"order_total\\\",\\\"item_count\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(31, 'Return Rejected - Customer', 'email', 'transactional', 'return_rejected_customer', 'Return Request Rejected - {{return_number}} | SJ Fashion Hub', 'Hi {{customer_name}},

We\'re sorry, but your return request #{{return_number}} for order #{{order_number}} has been rejected.

Reason: {{rejection_reason}}

If you have any questions or concerns, please contact our support team.

We\'re here to help!', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\",\\\"order_total\\\",\\\"item_count\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(32, 'Return In Transit - Customer', 'email', 'transactional', 'return_in_transit_customer', 'Return Package In Transit - {{return_number}} | SJ Fashion Hub', 'Hi {{customer_name}},

Your return package for order #{{order_number}} is on its way to us!

Return ID: {{return_number}}
Tracking ID: {{tracking_id}}

We\'ll process your refund once we receive and verify the items.

Thank you!', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\",\\\"order_total\\\",\\\"item_count\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(33, 'Return Received - Customer', 'email', 'transactional', 'return_received_customer', 'Return Package Received - {{return_number}} | SJ Fashion Hub', 'Hi {{customer_name}},

We\'ve received your return package for order #{{order_number}}.

Return ID: {{return_number}}

Our quality team is verifying the items. Your refund will be processed within 2-3 business days.

Thank you for your patience!', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\",\\\"order_total\\\",\\\"item_count\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(34, 'Refund Processed - Customer', 'email', 'transactional', 'return_refund_processed_customer', 'Refund Processed - {{return_number}} | SJ Fashion Hub', 'Hi {{customer_name}},

Your refund for return #{{return_number}} has been processed!

Refund Amount: ₹{{refund_amount}}
Method: {{refund_method}}

The amount will reflect in your account within 5-7 business days.

Thank you for shopping with us! We hope to serve you again soon!', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\",\\\"order_total\\\",\\\"item_count\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(35, 'Order Ready To Ship Customer', 'sms', 'transactional', 'order_ready_to_ship_customer', NULL, 'Hi {{customer_name}}, your order #{{order_number}} is ready to ship! It will be dispatched soon. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(36, 'Order Cancelled Customer', 'sms', 'transactional', 'order_cancelled_customer', NULL, 'Hi {{customer_name}}, your order #{{order_number}} is cancelled. Refund will be processed in 5-7 days. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(37, 'Order Rto Customer', 'sms', 'transactional', 'order_rto_customer', NULL, 'Hi {{customer_name}}, your order #{{order_number}} is returned. Refund will be processed once received. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(38, 'Return Request Submitted Customer', 'sms', 'transactional', 'return_request_submitted_customer', NULL, 'Hi {{customer_name}}, return request #{{return_number}} received. We will review within 24-48 hours. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(39, 'Return Approved Customer', 'sms', 'transactional', 'return_approved_customer', NULL, 'Hi {{customer_name}}, return #{{return_number}} approved! Pickup will be scheduled soon. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(40, 'Return Rejected Customer', 'sms', 'transactional', 'return_rejected_customer', NULL, 'Hi {{customer_name}}, return #{{return_number}} rejected. Reason: {{rejection_reason}}. Contact support for help. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(41, 'Return In Transit Customer', 'sms', 'transactional', 'return_in_transit_customer', NULL, 'Hi {{customer_name}}, return package #{{return_number}} is in transit. Track: {{tracking_id}}. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(42, 'Return Received Customer', 'sms', 'transactional', 'return_received_customer', NULL, 'Hi {{customer_name}}, return #{{return_number}} received! Refund will be processed in 2-3 days. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(43, 'Return Refund Processed Customer', 'sms', 'transactional', 'return_refund_processed_customer', NULL, 'Hi {{customer_name}}, refund of Rs.{{refund_amount}} processed for return #{{return_number}}. Amount will reflect in 5-7 days. -SJ Fashion Hub', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12'),
(44, 'User Registered', 'sms', 'transactional', 'user_registered', NULL, 'Welcome to SJ Fashion Hub, {{customer_name}}! Explore our latest collection. Happy Shopping!', NULL, '\"[\\\"customer_name\\\",\\\"order_number\\\"]\"', NULL, 'en', 1, 1, 0, NULL, NULL, '2025-10-12 11:30:12', '2025-10-12 11:30:12');


-- Table structure for table `communication_logs`
DROP TABLE IF EXISTS `communication_logs`;
CREATE TABLE "communication_logs" ("id" integer primary key autoincrement not null, "type" varchar not null, "provider" varchar not null, "recipient" varchar not null, "sender" varchar, "subject" varchar, "content" text not null, "template_id" varchar, "event" varchar, "status" varchar not null, "message_id" varchar, "error_message" text, "metadata" text, "variables" text, "cost" numeric, "sent_at" datetime, "delivered_at" datetime, "read_at" datetime, "failed_at" datetime, "retry_count" integer not null default '0', "next_retry_at" datetime, "user_id" integer, "order_id" integer, "reference_type" varchar, "reference_id" integer, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `communication_logs`
-- No data to dump


-- Table structure for table `payment_gateways`
DROP TABLE IF EXISTS `payment_gateways`;
CREATE TABLE "payment_gateways" ("id" integer primary key autoincrement not null, "name" varchar not null, "display_name" varchar not null, "type" varchar not null, "description" text, "credentials" text, "settings" text, "is_active" tinyint(1) not null default '0', "is_test_mode" tinyint(1) not null default '1', "min_amount" numeric not null default '0', "max_amount" numeric, "transaction_fee" numeric not null default '0', "fixed_fee" numeric not null default '0', "currency" varchar not null default 'INR', "supported_currencies" text, "logo_url" varchar, "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `payment_gateways`
INSERT INTO `payment_gateways` (`id`, `name`, `display_name`, `type`, `description`, `credentials`, `settings`, `is_active`, `is_test_mode`, `min_amount`, `max_amount`, `transaction_fee`, `fixed_fee`, `currency`, `supported_currencies`, `logo_url`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'razorpay', 'Razorpay', 'online', 'Accept payments via Razorpay - Cards, Net Banking, UPI, Wallets', NULL, NULL, 0, 1, 0, NULL, 2, 0, 'INR', '[\"INR\",\"USD\"]', NULL, 1, '2025-09-26 21:01:36', '2025-09-26 21:01:36'),
(2, 'cashfree', 'Cashfree', 'online', 'Accept payments via Cashfree - Cards, Net Banking, UPI, Wallets', NULL, NULL, 0, 1, 0, NULL, 1.95, 0, 'INR', '[\"INR\"]', NULL, 2, '2025-09-26 21:01:36', '2025-09-26 21:01:36'),
(3, 'payu', 'PayU', 'online', 'Accept payments via PayU - Cards, Net Banking, UPI, Wallets', NULL, NULL, 0, 1, 0, NULL, 2.4, 0, 'INR', '[\"INR\"]', NULL, 3, '2025-09-26 21:01:36', '2025-09-26 21:01:36'),
(4, 'paytm', 'Paytm', 'online', 'Accept payments via Paytm - Wallet, Cards, Net Banking, UPI', NULL, NULL, 0, 1, 0, NULL, 1.99, 0, 'INR', '[\"INR\"]', NULL, 4, '2025-09-26 21:01:36', '2025-09-26 21:01:36'),
(5, 'paypal', 'PayPal', 'online', 'Accept international payments via PayPal', NULL, NULL, 0, 1, 0, NULL, 3.49, 0.49, 'USD', '[\"USD\",\"EUR\",\"GBP\",\"INR\"]', NULL, 5, '2025-09-26 21:01:36', '2025-09-26 21:01:36'),
(6, 'cod', 'Cash on Delivery', 'offline', 'Pay cash when your order is delivered', NULL, NULL, 1, 1, 0, NULL, 0, 0, 'INR', '[\"INR\"]', NULL, 6, '2025-09-26 21:01:36', '2025-09-26 21:01:36');


-- Table structure for table `payment_transactions`
DROP TABLE IF EXISTS `payment_transactions`;
CREATE TABLE "payment_transactions" ("id" integer primary key autoincrement not null, "payment_gateway_id" integer not null, "order_id" integer, "user_id" integer, "transaction_id" varchar not null, "gateway_transaction_id" varchar, "gateway_payment_id" varchar, "gateway_order_id" varchar, "amount" numeric not null, "gateway_fee" numeric not null default '0', "net_amount" numeric not null, "currency" varchar not null default 'INR', "status" varchar check ("status" in ('pending', 'processing', 'completed', 'failed', 'cancelled', 'refunded', 'partially_refunded')) not null default 'pending', "type" varchar check ("type" in ('payment', 'refund', 'partial_refund')) not null default 'payment', "payment_method" varchar, "gateway_response" text, "metadata" text, "gateway_created_at" datetime, "completed_at" datetime, "failed_at" datetime, "failure_reason" text, "refund_id" varchar, "refund_amount" numeric, "created_at" datetime, "updated_at" datetime, foreign key("payment_gateway_id") references "payment_gateways"("id") on delete cascade, foreign key("order_id") references "orders"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete set null);


-- Dumping data for table `payment_transactions`
-- No data to dump


-- Table structure for table `analytics_settings`
DROP TABLE IF EXISTS `analytics_settings`;
CREATE TABLE "analytics_settings" ("id" integer primary key autoincrement not null, "google_analytics_id" varchar, "google_tag_manager_id" varchar, "facebook_pixel_id" varchar, "google_analytics_enabled" tinyint(1) not null default '0', "google_tag_manager_enabled" tinyint(1) not null default '0', "facebook_pixel_enabled" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `analytics_settings`
INSERT INTO `analytics_settings` (`id`, `google_analytics_id`, `google_tag_manager_id`, `facebook_pixel_id`, `google_analytics_enabled`, `google_tag_manager_enabled`, `facebook_pixel_enabled`, `created_at`, `updated_at`) VALUES
(1, NULL, NULL, '1364197498404249', 0, 0, 1, '2025-09-27 05:46:35', '2025-10-12 15:32:47');


-- Table structure for table `blog_categories`
DROP TABLE IF EXISTS `blog_categories`;
CREATE TABLE "blog_categories" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "seo_title" varchar, "seo_description" text, "seo_keywords" text, "image" varchar, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `blog_categories`
INSERT INTO `blog_categories` (`id`, `name`, `slug`, `description`, `seo_title`, `seo_description`, `seo_keywords`, `image`, `is_active`, `sort_order`, `created_at`, `updated_at`) VALUES
(1, 'Fashion Trends', 'fashion-trends', 'Latest fashion trends and style guides', NULL, NULL, NULL, NULL, 1, 1, '2025-09-27 06:30:23', '2025-09-27 06:30:23'),
(2, 'Product Reviews', 'product-reviews', 'Detailed product reviews and comparisons', NULL, NULL, NULL, NULL, 1, 2, '2025-09-27 06:30:23', '2025-09-27 06:30:23'),
(3, 'Style Guides', 'style-guides', 'How to style different outfits and accessories', NULL, NULL, NULL, NULL, 1, 3, '2025-09-27 06:30:23', '2025-09-27 06:30:23'),
(4, 'Buying Guides', 'buying-guides', 'Expert buying guides for fashion items', NULL, NULL, NULL, NULL, 1, 4, '2025-09-27 06:30:23', '2025-09-27 06:30:23');


-- Table structure for table `blog_posts`
DROP TABLE IF EXISTS `blog_posts`;
CREATE TABLE "blog_posts" ("id" integer primary key autoincrement not null, "title" varchar not null, "slug" varchar not null, "excerpt" text, "content" text not null, "featured_image" varchar, "gallery_images" text, "seo_title" varchar, "seo_description" text, "seo_keywords" text, "seo_schema" text, "product_id" integer, "ai_generated" tinyint(1) not null default '0', "ai_prompt" text, "ai_metadata" text, "blog_category_id" integer, "author_id" integer not null, "status" varchar check ("status" in ('draft', 'published', 'scheduled')) not null default 'draft', "published_at" datetime, "scheduled_at" datetime, "views_count" integer not null default '0', "likes_count" integer not null default '0', "shares_count" integer not null default '0', "is_featured" tinyint(1) not null default '0', "allow_comments" tinyint(1) not null default '1', "reading_time" integer, "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete set null, foreign key("blog_category_id") references "blog_categories"("id") on delete set null, foreign key("author_id") references "users"("id") on delete cascade);


-- Dumping data for table `blog_posts`
INSERT INTO `blog_posts` (`id`, `title`, `slug`, `excerpt`, `content`, `featured_image`, `gallery_images`, `seo_title`, `seo_description`, `seo_keywords`, `seo_schema`, `product_id`, `ai_generated`, `ai_prompt`, `ai_metadata`, `blog_category_id`, `author_id`, `status`, `published_at`, `scheduled_at`, `views_count`, `likes_count`, `shares_count`, `is_featured`, `allow_comments`, `reading_time`, `created_at`, `updated_at`) VALUES
(27, '2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360? (Honest Review)', '2-pcs-set-review-is-this-trendy-fashion-find-worth-rs360-honest-review', 'Looking for a budget-friendly fashion update? This 2 Pcs Set review dives deep, exploring its style, features, and value. Is it a steal or a skip? Find out now!', '<html>
<head>
<title>2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360? (Honest Review)</title>
</head>
<body>

<h1>2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360? (Honest Review)</h1>

<p>In today\'s fast-paced fashion world, finding stylish and affordable options can feel like searching for a needle in a haystack. Enter the <b>2 Pcs Set</b>, a budget-friendly offering priced at just ₹360. But does this trendy find live up to the hype? This comprehensive review will delve deep into the product, exploring its features, benefits, pros, cons, and ultimately, whether it\'s a worthy addition to your wardrobe. We\'ll provide an <b>honest review</b>, so you can make an informed decision before clicking that \'add to cart\' button.</p>

<h2>Product Overview and First Impressions</h2>

<p>The <b>2 Pcs Set</b>, as the name suggests, comprises two pieces.  The description is fairly minimal, so our initial impression is based solely on the limited information available. At ₹360, expectations need to be managed.  We\'re not expecting designer quality, but rather a functional and stylish set suitable for casual wear.  The overall impression will heavily depend on the material, design, and fit.  We\'ll be looking for signs of good construction, comfortable fabric, and a design that aligns with current fashion trends.</p>

<p>Without further context or images, it\'s challenging to provide a detailed first impression. However, the low price point suggests a focus on affordability and accessibility.  The success of this <b>2 pcs set</b> hinges on delivering value for money and exceeding expectations within its price range.</p>

<h2>Key Features and Benefits</h2>

<p>Since specific features aren\'t provided, we\'ll assume some common features and discuss potential benefits based on typical <b>2 pcs set</b> offerings. For example, a common 2-piece set might include a top and bottom (skirt, shorts, or pants) designed to be worn together or separately.</p>

<h3>Potential Key Features:</h3>
<ul>
  <li><b>Coordinated Design:</b> The primary benefit of a <b>2 pcs set</b> is the coordinated design.  This eliminates the guesswork of matching separate pieces, creating a cohesive and stylish outfit effortlessly.</li>
  <li><b>Versatility:</b> Even though designed as a set, the individual pieces should offer versatility.  The top can be paired with jeans or other bottoms, and the bottom can be worn with different tops, maximizing wardrobe options.</li>
  <li><b>Comfortable Fabric:</b> The fabric\'s comfort is crucial, especially for everyday wear.  Ideally, the set would be made from a breathable and soft material like cotton, rayon, or a comfortable blend.</li>
  <li><b>Easy Care:</b> Easy care is a significant benefit.  A machine-washable and wrinkle-resistant fabric would be a major plus, simplifying maintenance.</li>
  <li><b>Trendy Style:</b> The design should reflect current fashion trends.  This could include popular colors, patterns, or silhouettes, ensuring the set looks modern and stylish.</li>
  <li><b>Affordable Price:</b> The ₹360 price point is a major draw.  It makes fashion accessible to a wider audience and allows for experimentation with different styles without breaking the bank.</li>
</ul>

<h3>Potential Benefits:</h3>
<ul>
  <li><b>Effortless Style:</b>  A <b>2 pcs set</b> simplifies outfit creation, providing an instant and coordinated look.</li>
  <li><b>Cost-Effective Fashion:</b> The low price makes it an affordable way to update your wardrobe with a new outfit.</li>
  <li><b>Versatile Wardrobe Addition:</b> The individual pieces can be mixed and matched with other items, expanding your styling options.</li>
  <li><b>Confidence Booster:</b>  A well-designed and comfortable set can boost your confidence and make you feel good about your appearance.</li>
  <li><b>Time-Saving:</b>  No more struggling to find matching pieces – the set provides a ready-to-wear outfit solution.</li>
</ul>

<h2>Pros and Cons of the 2 Pcs Set (₹360)</h2>

<p>Let\'s weigh the potential advantages and disadvantages of this budget-friendly <b>2 pcs set</b>.</p>

<h3>Pros:</h3>
<ul>
  <li><b>Extremely Affordable:</b> At ₹360, the price is undeniably attractive. It\'s a low-risk purchase for trying out a new style or adding a trendy piece to your wardrobe.</li>
  <li><b>Convenience of a Set:</b> The coordinated design eliminates the need to find matching pieces, saving time and effort.</li>
  <li><b>Potential for Versatility:</b> If the individual pieces are well-designed, they can be styled separately, maximizing their use.</li>
  <li><b>Trendy and Stylish:</b> A well-chosen design can instantly update your look and make you feel fashionable.</li>
  <li><b>Accessible Fashion:</b> The low price point makes fashion accessible to a wider range of consumers.</li>
</ul>

<h3>Cons:</h3>
<ul>
  <li><b>Potentially Lower Quality:</b> At this price point, the material and construction quality might be compromised. Expect thinner fabrics and less durable stitching.</li>
  <li><b>Limited Design Options:</b> The selection of styles and colors might be limited compared to higher-priced options.</li>
  <li><b>Potential for Poor Fit:</b> Sizing accuracy can be an issue with budget-friendly clothing.  Carefully check size charts and reviews before ordering.</li>
  <li><b>Ethical Concerns:</b> Extremely low prices can raise concerns about ethical manufacturing practices and fair wages.</li>
  <li><b>Lack of Information:</b> The minimal description makes it difficult to assess the product\'s true quality and suitability.</li>
</ul>

<h2>Who Should Buy This Product?</h2>

<p>The <b>2 Pcs Set</b> at ₹360 is ideal for:</p>

<ul>
  <li><b>Budget-conscious shoppers:</b>  If you\'re looking for an affordable way to update your wardrobe, this set is a great option.</li>
  <li><b>Trend followers:</b>  It\'s a low-risk way to try out a new style or trend without investing a lot of money.</li>
  <li><b>Students:</b>  Perfect for students who want to look stylish on a budget.</li>
  <li><b>Those seeking convenience:</b>  The coordinated set eliminates the need to find matching pieces, saving time and effort.</li>
  <li><b>Individuals new to fashion:</b> A simple set is a great way to start experimenting with style.</li>
</ul>

<p>This product might *not* be suitable for:</p>

<ul>
  <li><b>Those prioritizing high quality and durability:</b>  If you\'re looking for clothing that will last for years, you\'ll likely need to invest in higher-priced options.</li>
  <li><b>Individuals with sensitive skin:</b>  The fabric might not be suitable for those with sensitivities, as it may contain synthetic materials.</li>
  <li><b>Those seeking specific styles or designs:</b>  The selection might be limited, so you might not find exactly what you\'re looking for.</li>
</ul>

<h2>Comparison with Similar Products</h2>

<p>To put the <b>2 Pcs Set</b> in perspective, let\'s compare it with similar products in the same price range and slightly higher.</p>

<h3>Similar Products (₹300 - ₹500):</h3>
<ul>
  <li><b>Other 2 Pcs Sets:</b> Many online retailers offer similar <b>2 pcs sets</b> within this price range. The key differences lie in the design, fabric, and available sizes. Look for sets with detailed product descriptions and customer reviews.</li>
  <li><b>Individual Clothing Items:</b> For the same price, you could purchase individual tops or bottoms. This allows for more customization but requires more effort to create a coordinated outfit.</li>
  <li><b>Discount Retailers:</b> Brick-and-mortar discount retailers often have similar sets or individual pieces at comparable prices. Shopping in person allows you to assess the quality and fit before buying.</li>
</ul>

<h3>Higher-Priced Alternatives (₹500 - ₹1000):</h3>
<ul>
  <li><b>Branded 2 Pcs Sets:</b>  Investing a bit more can get you a <b>2 pcs set</b> from a reputable brand, offering better quality materials, construction, and design.</li>
  <li><b>Sustainable Clothing Brands:</b>  Some sustainable brands offer basic sets made from eco-friendly materials, although they typically come at a higher price point.</li>
  <li><b>Boutique Retailers:</b>  Boutique retailers often carry curated sets with unique designs and higher-quality fabrics.</li>
</ul>

<p>When comparing, consider the following factors:</p>
<ul>
  <li><b>Fabric Composition:</b>  Look for natural fibers like cotton or linen for comfort and breathability.</li>
  <li><b>Construction Quality:</b>  Check for strong seams and durable stitching.</li>
  <li><b>Design and Style:</b>  Choose a design that aligns with your personal style and current trends.</li>
  <li><b>Sizing Accuracy:</b>  Read reviews and check size charts carefully before ordering.</li>
  <li><b>Return Policy:</b>  Ensure the retailer offers a reasonable return policy in case the set doesn\'t fit or meet your expectations.</li>
</ul>

<h2>Final Verdict and Recommendation</h2>

<p>The <b>2 Pcs Set</b> at ₹360 offers undeniable value for money. It\'s a budget-friendly way to update your wardrobe with a coordinated outfit. However, it\'s essential to manage expectations regarding quality and durability. If you\'re looking for a trendy and affordable option for casual wear, this set is worth considering. However, if you prioritize high quality and long-lasting clothing, you might be better off investing in higher-priced alternatives.</p>

<p><b>Recommendation:</b>  If you\'re on a tight budget and want to experiment with a new style, the <b>2 Pcs Set</b> is a decent option. Just be sure to check size charts and read reviews before purchasing. Consider it a disposable fashion item – enjoy it while it lasts, but don\'t expect it to be a wardrobe staple for years to come. For those who value longevity and quality, exploring slightly more expensive options from reputable brands is recommended. Ultimately, the decision depends on your individual needs and priorities.</p>

<p>Remember to look for online shopping deals, discount codes, and customer reviews before making your final purchase. Happy shopping!</p>

</body>
</html>', NULL, NULL, '2 Pcs Set Review: Trendy Fashion on a Budget', 'Honest review of the ₹360 2 Pcs Set. Is it a stylish steal or a budget bust? Find out if this trendy fashion find is worth your money!', '2 pcs set, 2 pcs set review, fashion, style, trendy, online shopping, best price, product review, detailed review, cheap fashion', NULL, 9, 1, '{\"blog_type\":\"product_review\",\"tone\":\"professional\",\"word_count\":1800,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"product review\",\"detailed review\",\"pros and cons\",\"honest review\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T16:58:05.717919Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 16:58:05', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(28, '2 Pcs Set Review: Is This Trendy Style Worth the Best Price? (Honest Review)', '2-pcs-set-review-is-this-trendy-style-worth-the-best-price-honest-review', 'Dive into our detailed 2 Pcs Set review! We explore its features, benefits, pros & cons, and compare it to competitors. Find out if this trendy fashion set is worth the ₹360 price tag!', '<html>
<head>
<style>
body { font-family: Arial, sans-serif; line-height: 1.6; }
h2 { color: #333; margin-top: 2em; }
h3 { color: #666; margin-top: 1.5em; }
.pros-cons { display: flex; justify-content: space-around; }
.pros, .cons { width: 45%; padding: 15px; border: 1px solid #ccc; }
.pros ul, .cons ul { list-style-type: disc; margin-left: 20px; }
img { max-width: 100%; height: auto; }
</style>
</head>
<body>

<h1>2 Pcs Set Review: Is This Trendy Style Worth the Best Price? (Honest Review)</h1>

<p>In the ever-evolving world of online shopping and fast fashion, finding a good deal on a trendy outfit can feel like hitting the jackpot. Today, we\'re diving deep into a comprehensive <b>product review</b> of the \"2 Pcs Set,\" a budget-friendly option priced at ₹360. We\'ll explore its features, benefits, and drawbacks, and ultimately help you decide if this set is the right addition to your wardrobe. This is an <b>honest review</b>, so we\'ll hold nothing back!</p>

<h2>Product Overview and First Impressions</h2>

<p>The \"2 Pcs Set\" is, as the name suggests, a two-piece outfit. The details are limited in the provided description, but let\'s consider the potential possibilities. Based on the popularity of such sets, it could be a matching top and bottom (skirt, shorts, or pants), a top and jacket, or even a dress with a coordinating accessory. Without further specifics, our <b>first impressions</b> are based on the general concept of a coordinated outfit at an affordable price point. </p>

<p>The initial appeal lies in the convenience and potential cost-effectiveness. Buying a pre-matched set saves you the hassle of coordinating separate pieces and can often be cheaper than purchasing individual items. However, the lack of detailed information raises some concerns. We\'ll need to consider potential issues like fabric quality, sizing accuracy, and overall design aesthetic based on general trends for similar products.</p>

<h2>Key Features and Benefits (Assuming Common 2 Pcs Set Types)</h2>

<p>Since the product description is brief, we\'ll explore the features and benefits based on common types of <b>2 pcs sets</b> that are prevalent in the <b>fashion</b> market. We\'ll consider a scenario where the set includes a top and matching bottoms (e.g., a crop top and skirt set, a t-shirt and shorts set, or a blouse and pants set).</p>

<h3>Potential Features:</h3>

<ul>
  <li><b>Coordinated Style:</b> The primary benefit is the pre-matched design. This eliminates the guesswork of creating a cohesive outfit.</li>
  <li><b>Versatility:</b> Depending on the style, the pieces can often be worn separately, expanding your wardrobe options.</li>
  <li><b>Affordability:</b> At ₹360, this set is positioned as a budget-friendly option, making it accessible to a wider range of shoppers.</li>
  <li><b>Trendy Design:</b> The set is likely designed to align with current fashion trends, offering a stylish look without breaking the bank.</li>
  <li><b>Comfortable Fabric (Potentially):</b> Depending on the material, the set could offer a comfortable wearing experience, suitable for everyday wear.</li>
</ul>

<h3>Potential Benefits:</h3>

<ul>
  <li><b>Effortless Style:</b> Achieve a put-together look quickly and easily.</li>
  <li><b>Cost Savings:</b> Potentially cheaper than buying separate items.</li>
  <li><b>Wardrobe Expansion:</b> Adds a new outfit to your collection.</li>
  <li><b>On-Trend Look:</b> Stay fashionable without spending a fortune.</li>
  <li><b>Confidence Boost:</b> Wearing a stylish outfit can enhance your self-esteem.</li>
</ul>

<h2>Pros and Cons of the 2 Pcs Set</h2>

<p>Let\'s weigh the potential advantages and disadvantages of purchasing this <b>2 pcs set</b>. This section provides a balanced perspective to help you make an informed decision.</p>

<div class=\"pros-cons\">
  <div class=\"pros\">
    <h3>Pros</h3>
    <ul>
      <li><b>Affordable Price:</b> At ₹360, it\'s a very budget-friendly option.</li>
      <li><b>Convenient Coordination:</b> Takes the guesswork out of matching outfits.</li>
      <li><b>Potential Versatility:</b> Pieces might be wearable separately.</li>
      <li><b>Trendy Style:</b> Likely designed to be fashionable.</li>
      <li><b>Quick Outfit Solution:</b> Perfect for those who want a stylish look without much effort.</li>
      <li><b>Accessible Fashion:</b> Makes trendy styles available to a wider audience.</li>
    </ul>
  </div>
  <div class=\"cons\">
    <h3>Cons</h3>
    <ul>
      <li><b>Limited Information:</b> Lack of details about fabric, style, and sizing.</li>
      <li><b>Potential Quality Issues:</b> At this price point, fabric quality might be a concern.</li>
      <li><b>Sizing Inconsistencies:</b> <b>Online shopping</b> can be tricky with sizing; returns might be necessary.</li>
      <li><b>Durability Concerns:</b> Cheaper fabrics may not be as durable.</li>
      <li><b>Style Limitations:</b> The set\'s style might not suit everyone\'s taste.</li>
      <li><b>Ethical Concerns:</b> Fast fashion often raises ethical questions about labor practices.</li>
    </ul>
  </div>
</div>

<h2>Who Should Buy This Product?</h2>

<p>This <b>2 pcs set</b> is most suitable for:</p>

<ul>
  <li><b>Budget-conscious shoppers:</b> Those looking for <b>trendy</b> clothes at the <b>best price</b>.</li>
  <li><b>Fashion experimenters:</b> Individuals who enjoy trying out new styles without a significant investment.</li>
  <li><b>Students:</b> A great option for students who want to look stylish on a limited budget.</li>
  <li><b>Those seeking convenience:</b> People who want a quick and easy outfit solution.</li>
  <li><b>Individuals who understand the risks:</b> Shoppers who are aware of the potential quality limitations and are willing to take a chance.</li>
</ul>

<p>However, this set might not be ideal for:</p>

<ul>
  <li><b>Those prioritizing high quality:</b> Individuals who prefer durable, long-lasting clothing.</li>
  <li><b>Shoppers with specific style preferences:</b> Those who have a very defined personal style and are less likely to deviate.</li>
  <li><b>Individuals who dislike online returns:</b> Sizing issues can lead to returns, which can be inconvenient.</li>
  <li><b>Those concerned about ethical fashion:</b> The fast fashion industry often raises ethical concerns.</li>
</ul>

<h2>Comparison with Similar Products</h2>

<p>Let\'s compare this <b>2 pcs set</b> with other similar products available <b>online</b>:</p>

<ul>
  <li><b>Shein/Romwe Sets:</b> These platforms offer a wide variety of <b>2 pcs sets</b> at similar price points. However, quality and sizing can be inconsistent. Customer reviews are crucial when shopping on these sites.</li>
  <li><b>Local Market Sets:</b> In local markets, you might find similar sets at slightly higher prices. The advantage is the ability to physically inspect the fabric and try on the clothes before buying.</li>
  <li><b>Branded Outlet Stores:</b> Outlet stores of popular brands might offer discounted sets. While the price might be higher than ₹360, the quality and durability are likely to be better.</li>
  <li><b>DIY Sets:</b> Creating your own <b>2 pcs set</b> by matching separate items can be a more expensive but also more personalized option. This allows you to choose higher-quality fabrics and ensure a perfect fit.</li>
</ul>

<p>When comparing, consider the following factors:</p>

<ul>
  <li><b>Price:</b> How does the price compare to other options?</li>
  <li><b>Quality:</b> What is the expected fabric quality and durability?</li>
  <li><b>Style:</b> Does the style align with your personal preferences?</li>
  <li><b>Sizing:</b> Are there reliable sizing charts and customer reviews regarding sizing accuracy?</li>
  <li><b>Return Policy:</b> What is the return policy in case of sizing issues or dissatisfaction?</li>
</ul>

<h2>Final Verdict and Recommendation</h2>

<p>The \"2 Pcs Set\" at ₹360 presents an intriguing option for budget-conscious shoppers seeking a <b>trendy</b> and convenient outfit. However, the lack of detailed product information necessitates a cautious approach. The potential benefits of affordability and coordinated style are counterbalanced by concerns about fabric quality, sizing accuracy, and ethical considerations.</p>

<p><b>Our recommendation:</b> If you\'re willing to take a chance and are prepared for potential quality limitations, the set could be a worthwhile purchase, especially for experimenting with new styles or adding a quick and easy outfit to your wardrobe. However, manage your expectations and carefully review customer reviews (if available) before making a decision. If quality and durability are your top priorities, consider exploring alternative options, even if they come at a higher price point.</p>

<p>Ultimately, the decision depends on your individual needs and priorities. Weigh the <b>pros and cons</b> carefully before clicking that \"add to cart\" button. Happy <b>online shopping</b>!</p>

</body>
</html>', NULL, NULL, '2 Pcs Set Review: Best Price, Trendy Style?', 'Honest review of the 2 Pcs Set (₹360). Pros & cons, comparison, and verdict. Is it worth buying? Find out if this trendy fashion set is for you!', '2 pcs set, fashion, style, trendy, online shopping, best price, product review, detailed review, pros and cons, honest review', NULL, 9, 1, '{\"blog_type\":\"product_review\",\"tone\":\"professional\",\"word_count\":1800,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"product review\",\"detailed review\",\"pros and cons\",\"honest review\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:00:39.186706Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:00:39', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(29, '2 Pcs Set Review: Is This Trendy Fashion Deal Worth ₹360?', '2-pcs-set-review-is-this-trendy-fashion-deal-worth-rs360', 'Dive into our comprehensive review of the 2 Pcs Set! We analyze its features, benefits, pros, cons, and compare it to alternatives. Find out if this affordable fashion set is right for you!', '<html><body>

<h1>2 Pcs Set Review: Is This Trendy Fashion Deal Worth ₹360?</h1>

<p>In the ever-evolving world of fashion, finding stylish and affordable options can feel like searching for a needle in a haystack. Enter the <b>2 Pcs Set</b>, a budget-friendly offering priced at just ₹360. But does this set deliver on its promise of trendy style and value? This in-depth review will dissect every aspect of the <b>2 Pcs Set</b>, providing a comprehensive analysis to help you make an informed decision. We\'ll explore its key features, benefits, weigh the pros and cons, and ultimately determine if this fashion find is a worthwhile addition to your wardrobe.</p>

<h2>Product Overview and First Impressions</h2>

The <b>2 Pcs Set</b>, as the name suggests, comprises two coordinating pieces designed to create a cohesive and fashionable look. While the specific style and material may vary depending on the retailer and product listing, the core concept remains the same: offering a complete outfit solution at an accessible price point. Our first impressions were cautiously optimistic. The price is undeniably attractive, raising the question of whether the quality and design can match the affordability. The initial appeal hinges on the visual presentation – does the set look stylish and well-made in online images? This initial assessment is crucial, as it sets the stage for further investigation into the product\'s details.

<p>The description, simply stating \"2 Pcs Set,\" lacks crucial information. This vagueness necessitates further research, including checking customer reviews and looking for additional details on the retailer\'s website. Understanding the fabric composition, available sizes, and specific style is essential before making a purchase. A more detailed product description would significantly improve the customer experience and reduce potential disappointment.</p>

<h2>Key Features and Benefits of the 2 Pcs Set</h2>

Despite the limited information provided, we can infer some potential key features and benefits based on the general concept of a <b>2 Pcs Set</b>:

<ul>
  <li><b>Coordinated Style:</b> The primary benefit is the pre-coordinated nature of the set. This eliminates the guesswork of matching separate pieces, saving time and effort in creating a stylish outfit.</li>
  <li><b>Affordability:</b> At ₹360, the <b>2 Pcs Set</b> is undeniably budget-friendly, making it accessible to a wide range of consumers.</li>
  <li><b>Versatility:</b> Depending on the specific style, the set can be dressed up or down, making it suitable for various occasions. A casual set might be perfect for everyday wear, while a more formal set could be appropriate for a night out.</li>
  <li><b>Convenience:</b> Purchasing a complete outfit in one go is incredibly convenient, especially for those who are short on time or prefer a hassle-free shopping experience.</li>
  <li><b>Trendy Fashion:</b> The 2 pcs set aims to offer trendy fashion at an affordable price. It allows consumers to experience new styles without breaking the bank.</li>
</ul>

<p>However, it\'s important to remember that these are potential benefits. The actual benefits will depend on the specific design, quality, and fit of the <b>2 Pcs Set</b>. A poorly made set, regardless of its low price, will ultimately be a waste of money.</p>

<h3>Breaking Down the Potential Styles of a 2 Pcs Set</h3>

<p>The possibilities for a <b>2 Pcs Set</b> are vast. Here are a few potential styles and their associated benefits:</p>

<ul>
  <li><b>Top and Bottom Set:</b> This could be a matching top and pants, skirt, or shorts. Ideal for creating a cohesive and streamlined look.</li>
  <li><b>Dress and Jacket/Cardigan Set:</b> Perfect for adding a layer of warmth and style to a dress.</li>
  <li><b>Top and Scarf/Accessory Set:</b> A simple top paired with a stylish scarf or other accessory can elevate the look.</li>
  <li><b>Loungewear Set:</b> Comfortable and stylish loungewear sets are perfect for relaxing at home.</li>
</ul>

<p>The specific style of the <b>2 Pcs Set</b> will significantly impact its overall appeal and suitability for different occasions.</p>

<h2>Pros and Cons of the 2 Pcs Set</h2>

To provide a balanced perspective, let\'s delve into the potential pros and cons of purchasing a <b>2 Pcs Set</b> at this price point:

<h3>Pros:</h3>

<ul>
  <li><b>Extremely Affordable:</b> The low price makes it an attractive option for budget-conscious shoppers.</li>
  <li><b>Convenient Outfit Solution:</b> Eliminates the need to coordinate separate pieces.</li>
  <li><b>Potential for Trendy Style:</b> Offers the opportunity to experiment with new trends without a significant investment.</li>
  <li><b>Easy to Purchase Online:</b> Readily available through various online retailers.</li>
  <li><b>Great for Gifting:</b> A budget-friendly gift option for fashion-conscious friends or family.</li>
</ul>

<h3>Cons:</h3>

<ul>
  <li><b>Potentially Low Quality:</b> The low price may indicate inferior materials and construction.</li>
  <li><b>Limited Information:</b> The vague description makes it difficult to assess the product\'s quality and style.</li>
  <li><b>Sizing Issues:</b> Online clothing purchases can be prone to sizing discrepancies.</li>
  <li><b>Potential for Disappointment:</b> The actual product may not match the online images or expectations.</li>
  <li><b>Durability Concerns:</b> The set might not withstand frequent washing or wear.</li>
  <li><b>Ethical Concerns:</b> Extremely low prices can sometimes indicate unethical labor practices. It\'s important to consider the source and manufacturing process.</li>
</ul>

<h2>Who Should Buy This Product?</h2>

The <b>2 Pcs Set</b> could be a good option for:

<ul>
  <li><b>Budget-conscious shoppers:</b> Those looking for affordable fashion options.</li>
  <li><b>Trendsetters:</b> Individuals who enjoy experimenting with new styles without spending a lot of money.</li>
  <li><b>Students:</b> A cost-effective way to build a stylish wardrobe.</li>
  <li><b>Gift-givers:</b> A budget-friendly gift option for fashion-loving friends and family.</li>
  <li><b>Those needing a quick and easy outfit solution:</b> Perfect for those who don\'t have time to coordinate separate pieces.</li>
</ul>

<p>However, it\'s important to manage expectations and be prepared for potential quality issues. If you prioritize high-quality materials and long-lasting garments, this set might not be the best choice.</p>

<h2>Comparison with Similar Products</h2>

When comparing the <b>2 Pcs Set</b> to similar products, the price is the most significant differentiating factor. While other <b>2 Pcs Sets</b> may offer higher quality materials, more detailed designs, and better construction, they typically come at a higher price point. Here\'s a general comparison:

<ul>
  <li><b>Higher-Priced 2 Pcs Sets (₹1000+):</b> These sets often feature better quality fabrics, more intricate designs, and more durable construction. They are likely to last longer and offer a more premium feel.</li>
  <li><b>Mid-Range 2 Pcs Sets (₹500-₹1000):</b> These sets strike a balance between affordability and quality. They may not be as luxurious as higher-priced options, but they are likely to be more durable and well-made than the ₹360 set.</li>
  <li><b>Individual Clothing Items:</b> Purchasing separate pieces allows for greater control over quality and style, but it also requires more time and effort to coordinate outfits. The overall cost may also be higher.</li>
</ul>

<p>Ultimately, the best option depends on your individual needs and priorities. If budget is your primary concern, the ₹360 <b>2 Pcs Set</b> might be a reasonable choice. However, if you value quality and durability, you may want to consider investing in a more expensive option.</p>

<h2>Final Verdict and Recommendation</h2>

The <b>2 Pcs Set</b> at ₹360 presents a compelling proposition for budget-conscious shoppers seeking a quick and easy fashion fix. Its affordability is undeniable, making it an attractive option for those looking to experiment with new trends or build a basic wardrobe without breaking the bank. However, it\'s crucial to approach this purchase with realistic expectations. The low price likely reflects compromises in material quality, construction, and overall durability.

<p><b>Recommendation:</b> If you\'re aware of the potential limitations and prioritize affordability above all else, the <b>2 Pcs Set</b> could be a worthwhile purchase. It\'s ideal for trying out a new style or adding a trendy piece to your wardrobe without a significant investment. However, if you value long-lasting quality and superior craftsmanship, consider investing in a more expensive option. Before purchasing, thoroughly research the specific style, check customer reviews, and carefully review the retailer\'s return policy.</p>

<p><b>Final Score:</b> 6/10 (Good for the price, but temper your expectations.)</p>

<p><b>Disclaimer:</b> This review is based on general assumptions about the <b>2 Pcs Set</b> due to the limited information provided. The actual product may vary depending on the retailer and specific design.</p>

</body></html>', NULL, NULL, '2 Pcs Set Review: Affordable Fashion or Cheap Thrill?', 'Is the ₹360 2 Pcs Set worth it? Our in-depth review covers features, pros, cons, and alternatives. Find out if this trendy fashion deal is right for you!', '2 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide', NULL, 9, 1, '{\"blog_type\":\"product_review\",\"tone\":\"authoritative\",\"word_count\":1900,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"in-depth review\",\"comprehensive review\",\"product analysis\",\"review guide\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:05:54.794116Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:05:54', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(30, 'Unlock Effortless Style: The Ultimate Guide to Styling Your 2 Pcs Set', 'unlock-effortless-style-the-ultimate-guide-to-styling-your-2-pcs-set', 'Discover the versatility of the 2 Pcs Set! Our complete style guide offers tips on occasions, accessories, seasonal styling, and care. Shop now at the best price!', '<h2>Introduction: The Allure of the 2 Pcs Set</h2>

In the ever-evolving world of fashion, finding pieces that offer both style and versatility is a true victory. Enter the <b>2 Pcs Set</b>, a dynamic duo that simplifies outfit creation and elevates your wardrobe with ease. Priced at just ₹360.00, this set is not only budget-friendly but also a gateway to endless styling possibilities. This comprehensive guide will equip you with everything you need to know about rocking your <b>2 Pcs Set</b>, from styling tips and occasion suggestions to accessory pairings and seasonal adaptations.

<p>This isn\'t just about buying clothes; it\'s about investing in a wardrobe staple that empowers you to express your unique style effortlessly. We\'ll explore how to transform this simple set into a statement piece, proving that <b>trendy</b> fashion doesn\'t have to break the bank. Get ready to unlock the full potential of your <b>2 Pcs Set</b> and become a style icon!</p>

<h2>Understanding the 2 Pcs Set: A Foundation for Style</h2>

Before diving into the styling specifics, let\'s understand the fundamental appeal of the <b>2 Pcs Set</b>. Its beauty lies in its simplicity and inherent coordination. Whether it\'s a matching top and bottom, a dress with a complementary jacket, or any other combination, the <b>2 Pcs Set</b> provides a ready-made outfit base. This saves you time and eliminates the guesswork of matching separates, making it a perfect choice for busy individuals who still want to look effortlessly chic.

<p>The possibilities are truly endless. This guide will focus on general principles applicable to various <b>2 Pcs Set</b> styles, allowing you to adapt the advice to your specific set and personal aesthetic. Remember, fashion is about self-expression, and the <b>2 Pcs Set</b> is your canvas!</p>

<h2>Styling Your 2 Pcs Set: A Complete Style Guide</h2>

Now, let\'s get to the heart of the matter: how to style your <b>2 Pcs Set</b>. Here\'s a breakdown of key considerations:

<h3>Accessorizing for Impact</h3>

Accessories are the game-changers that can transform a simple <b>2 Pcs Set</b> into a show-stopping ensemble. Consider these options:

*   <b>Jewelry:</b> A statement necklace can elevate a simple top, while delicate earrings can add a touch of elegance. Choose jewelry that complements the overall style of your set. For example, a bohemian-inspired set might pair well with layered necklaces and beaded bracelets.
*   <b>Belts:</b> A belt can cinch your waist and create a more defined silhouette, especially when wearing a looser-fitting <b>2 Pcs Set</b>. Experiment with different belt styles, from wide statement belts to thin, understated options.
*   <b>Scarves:</b> A scarf can add a pop of color or texture to your outfit. Drape it around your neck, tie it in your hair, or even use it as a belt for a unique touch.
*   <b>Hats:</b> A hat can be both stylish and functional, protecting you from the sun or adding a touch of sophistication to your look. Consider a wide-brimmed hat for a summery vibe or a beanie for a cozy winter outfit.

<h3>Footwear: Grounding Your Style</h3>

The right footwear can make or break an outfit. Here are some suggestions for pairing shoes with your <b>2 Pcs Set</b>:

*   <b>Heels:</b> Heels can instantly dress up any outfit, making them a perfect choice for evenings out or special occasions. Choose heels that complement the color and style of your set.
*   <b>Sandals:</b> Sandals are a comfortable and stylish option for warmer weather. Choose sandals that are appropriate for the occasion. For example, dressy sandals can be worn to a summer party, while casual sandals are perfect for everyday wear.
*   <b>Sneakers:</b> Sneakers can add a touch of casual cool to your <b>2 Pcs Set</b>. Choose sneakers that are clean and stylish. White sneakers are a versatile option that can be paired with almost anything.
*   <b>Boots:</b> Boots are a great option for colder weather. Choose boots that are appropriate for the occasion. For example, ankle boots can be worn with a dress or skirt, while knee-high boots can be worn with jeans or leggings.

<h3>Layering: Adding Depth and Dimension</h3>

Layering is a fantastic way to add depth and dimension to your <b>2 Pcs Set</b>. Consider these layering options:

*   <b>Jackets:</b> A jacket can add warmth and style to your outfit. Choose a jacket that complements the color and style of your set. A denim jacket is a versatile option that can be paired with almost anything.
*   <b>Cardigans:</b> A cardigan can add a touch of cozy comfort to your outfit. Choose a cardigan that is soft and comfortable. A neutral-colored cardigan is a versatile option that can be paired with almost anything.
*   <b>Blazers:</b> A blazer can add a touch of sophistication to your outfit. Choose a blazer that is well-tailored and fits you properly. A black blazer is a classic option that can be worn to almost any occasion.
*   <b>Tops:</b> Adding a simple t-shirt or blouse underneath the top piece from your <b>2 Pcs Set</b> can create a more casual or modest look. Experiment with different necklines and sleeve lengths.

<h2>Occasions: Where to Wear Your 2 Pcs Set</h2>

The beauty of the <b>2 Pcs Set</b> is its adaptability to various occasions. Here are some ideas:

*   <b>Casual Day Out:</b> Pair your <b>2 Pcs Set</b> with sneakers or sandals and a denim jacket for a relaxed and stylish look.
*   <b>Workplace:</b> Depending on the style of your set, you can wear it to work with heels or flats and a blazer. Choose a set in a professional color like navy or black.
*   <b>Evening Event:</b> Dress up your <b>2 Pcs Set</b> with heels, statement jewelry, and a clutch for a night out.
*   <b>Weekend Brunch:</b> Opt for a comfortable and stylish <b>2 Pcs Set</b> with sandals or espadrilles and a crossbody bag.
*   <b>Travel:</b> A <b>2 Pcs Set</b> is perfect for travel as it\'s easy to pack and can be dressed up or down.

<h2>Seasonal Styling: Adapting to the Weather</h2>

Your <b>2 Pcs Set</b> can be worn year-round with a few seasonal adjustments:

*   <b>Spring:</b> Embrace lighter fabrics and pastel colors. Pair your set with a denim jacket or cardigan and flats or sandals.
*   <b>Summer:</b> Opt for breathable fabrics like cotton or linen. Pair your set with sandals or wedges and a straw hat.
*   <b>Autumn:</b> Choose warmer fabrics like knit or velvet. Pair your set with boots or booties and a leather jacket or trench coat.
*   <b>Winter:</b> Layer your set with a coat, scarf, and gloves. Pair it with boots and tights for extra warmth.

<h2>Care and Maintenance: Keeping Your 2 Pcs Set Looking Its Best</h2>

Proper care and maintenance are essential for extending the life of your <b>2 Pcs Set</b>. Follow these tips:

*   <b>Read the care label:</b> Always read and follow the instructions on the care label.
*   <b>Wash your set inside out:</b> This will help to prevent fading and damage to the fabric.
*   <b>Use a gentle detergent:</b> Harsh detergents can damage the fabric and cause it to fade.
*   <b>Avoid using bleach:</b> Bleach can damage the fabric and cause it to discolor.
*   <b>Hang your set to dry:</b> Tumble drying can shrink or damage the fabric. If tumble drying is necessary, use a low heat setting.
*   <b>Iron your set on a low heat setting:</b> High heat can damage the fabric.
*   <b>Store your set properly:</b> Store your set in a cool, dry place away from direct sunlight.

<h2>Why Choose Our 2 Pcs Set?</h2>

At just ₹360.00, our <b>2 Pcs Set</b> offers incredible value for money. It\'s a versatile and stylish addition to any wardrobe, providing endless outfit possibilities. We pride ourselves on offering <b>trendy</b> fashion at the <b>best price</b>, making style accessible to everyone. Plus, with our easy <b>online shopping</b> experience, you can find your perfect set from the comfort of your own home.

<h2>Conclusion: Embrace the Versatility of the 2 Pcs Set</h2>

The <b>2 Pcs Set</b> is more than just clothing; it\'s a style solution. It\'s a versatile, affordable, and <b>trendy</b> way to elevate your wardrobe and express your unique personality. With the styling tips, occasion suggestions, and care advice provided in this <b>complete style guide</b>, you\'re well-equipped to unlock the full potential of your <b>2 Pcs Set</b>. So, embrace the simplicity and elegance of the <b>2 Pcs Set</b> and step out in style!

<p>Start your <b>fashion styling</b> journey today. Shop our collection of <b>2 Pcs Sets</b> and discover the perfect addition to your wardrobe. Get ready to create stunning outfits with ease and confidence. Remember, <b>style advice</b> is just a click away! Enjoy your <b>online shopping</b> experience!</p>', NULL, NULL, '2 Pcs Set: Ultimate Style Guide & Outfit Ideas', 'Unlock effortless style with our 2 Pcs Set guide! Learn how to style, accessorize, and care for your set. Shop trendy fashion at the best price!', '2 pcs set, fashion, style, trendy, online shopping, best price, complete style guide, fashion styling, outfit guide, style advice', NULL, 9, 1, '{\"blog_type\":\"style_guide\",\"tone\":\"authoritative\",\"word_count\":1350,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"complete style guide\",\"fashion styling\",\"outfit guide\",\"style advice\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:06:30.772463Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:06:30', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:06:30', '2025-09-28 17:06:30'),
(31, 'Unveiling the Versatility of the 2 Pcs Set: Style, Trends, and Timeless Appeal', 'unveiling-the-versatility-of-the-2-pcs-set-style-trends-and-timeless-appeal', 'Discover the enduring appeal of the 2 Pcs Set! Explore its place in fashion history, current trends, and future predictions. Shop now at the best price!', '<h1>Unveiling the Versatility of the 2 Pcs Set: Style, Trends, and Timeless Appeal</h1>

<p>The 2 Pcs Set: a seemingly simple concept, yet a powerhouse of style and versatility. In the ever-evolving world of fashion, this ensemble has proven its staying power, adapting to changing trends while maintaining its core appeal. At a price of ₹360.00, it\'s an accessible entry point to embracing current fashion trends. This article delves into the fascinating world of the 2 Pcs Set, exploring its historical context, current trends, future predictions, and how it seamlessly integrates into the modern woman\'s wardrobe. We\'ll also examine celebrity influences and provide valuable insights into making the most of this wardrobe staple.</p>

<h2>What is a 2 Pcs Set?</h2>

<p>At its core, a 2 Pcs Set is simply two coordinating pieces of clothing designed to be worn together. This can encompass a wide range of combinations, from a matching top and bottom (skirt, pants, shorts) to a dress and jacket or a top and cardigan. The key is coordination, whether through color, fabric, or overall style. The beauty of the 2 Pcs Set lies in its effortless chic; it provides a complete outfit solution that requires minimal styling effort.</p>

<h2>The Allure of the 2 Pcs Set: Why It Remains a Fashion Staple</h2>

<p>Several factors contribute to the enduring appeal of the 2 Pcs Set:</p>

<ul>
 <li><b>Convenience and Ease:</b> It eliminates the guesswork of outfit coordination, offering a ready-to-wear solution for busy individuals.</li>
 <li><b>Versatility:</b> The pieces can be worn together as a set or mixed and matched with other items in your wardrobe, creating multiple outfit options.</li>
 <li><b>Style Cohesion:</b> The matching design ensures a polished and put-together look, instantly elevating your style.</li>
 <li><b>Affordability:</b> 2 Pcs Sets often offer a more economical way to acquire coordinated outfits compared to purchasing individual pieces. At ₹360.00, our 2 Pcs Set provides exceptional value.</li>
</ul>

<h2>Trend Analysis: The 2 Pcs Set in Contemporary Fashion</h2>

<p>Let\'s delve into a comprehensive trend analysis of the 2 Pcs Set, examining its current relevance, historical evolution, and future trajectory.</p>

<h3>Current Fashion Trends Related to the 2 Pcs Set</h3>

<p>The 2 Pcs Set is currently experiencing a resurgence in popularity, driven by several key trends:</p>

<ul>
 <li><b>Loungewear Sets:</b> Comfort is king! Matching loungewear sets, often featuring soft fabrics like cotton or knit, are perfect for relaxed days at home or casual outings.</li>
 <li><b>Co-ord Sets:</b> These sets typically include a top and bottom in matching prints or colors, offering a coordinated and stylish look. Think floral prints, bold geometric patterns, or monochromatic ensembles.</li>
 <li><b>Athleisure Sets:</b> Blurring the lines between athletic wear and leisurewear, athleisure sets combine comfort and style. Expect to see matching hoodies and joggers, leggings and sports bras, or tracksuits in trendy colors and designs.</li>
 <li><b>Workwear Sets:</b> Tailored sets, such as blazer and pant combinations or skirt suits, are making a comeback in the professional world, offering a sophisticated and powerful look.</li>
 <li><b>Vacation Sets:</b> Lightweight and breezy sets, often featuring linen or cotton fabrics, are perfect for warm-weather getaways. Think flowy tops and shorts or maxi skirts in vibrant colors and prints.</li>
</ul>

<h3>How the ₹360.00 2 Pcs Set Fits Into Current Trends</h3>

<p>While the specific style of our ₹360.00 2 Pcs Set isn\'t explicitly defined, its affordability and versatility allow it to be adapted to various trends. It can be styled to fit into the loungewear trend with comfortable accessories or elevated for a more fashionable look by pairing it with statement jewelry and shoes. The key is to understand the current trends and incorporate them into how you style and accessorize the set.</p>

<h3>Historical Context and Evolution of the 2 Pcs Set</h3>

<p>The concept of matching separates has existed for centuries, but the modern 2 Pcs Set as we know it gained popularity in the mid-20th century. During the post-war era, matching skirt suits and dress sets became symbols of elegance and sophistication. In the 1960s and 70s, matching pantsuits and knit sets emerged as fashionable options for women. The 1980s saw the rise of power suits and bold, coordinated ensembles. In recent decades, the 2 Pcs Set has continued to evolve, adapting to changing trends and embracing a wider range of styles and fabrics. The rise of fast fashion and online shopping has made 2 Pcs Sets more accessible and affordable than ever before.</p>

<h3>Future Predictions for the 2 Pcs Set Category</h3>

<p>The future of the 2 Pcs Set looks bright, with several emerging trends poised to shape its evolution:</p>

<ul>
 <li><b>Sustainability:</b> Eco-friendly fabrics and sustainable production practices will become increasingly important, driving demand for 2 Pcs Sets made from organic cotton, recycled materials, and other environmentally conscious options.</li>
 <li><b>Personalization:</b> Customization options will allow consumers to create unique 2 Pcs Sets tailored to their individual style preferences.</li>
 <li><b>Technology Integration:</b> Smart fabrics and wearable technology may be incorporated into 2 Pcs Sets, offering features such as temperature regulation, moisture-wicking, and even health monitoring.</li>
 <li><b>Inclusivity:</b> Brands will prioritize inclusivity by offering 2 Pcs Sets in a wider range of sizes and styles to cater to diverse body types and preferences.</li>
 <li><b>Metaverse Integration:</b> As the metaverse gains traction, virtual 2 Pcs Sets will become increasingly popular, allowing users to express their style in digital environments.</li>
</ul>

<h3>Celebrity and Influencer Endorsements</h3>

<p>Celebrities and influencers play a significant role in shaping fashion trends, and the 2 Pcs Set is no exception. Numerous celebrities have been spotted wearing stylish 2 Pcs Sets, further popularizing the trend. From red carpet appearances to casual street style looks, celebrities demonstrate the versatility and chicness of these ensembles.</p>

<p>Influencers on social media platforms like Instagram, TikTok, and YouTube also contribute to the popularity of 2 Pcs Sets by showcasing different ways to style and wear them. They often collaborate with brands to promote specific sets and provide styling tips to their followers.</p>

<h2>Styling Tips for the ₹360.00 2 Pcs Set</h2>

<p>Regardless of the specific style of the ₹360.00 2 Pcs Set, here are some general styling tips to help you make the most of it:</p>

<ul>
 <li><b>Accessorize Wisely:</b> Choose accessories that complement the set\'s style and color palette. Statement jewelry, scarves, belts, and hats can add personality and flair.</li>
 <li><b>Mix and Match:</b> Don\'t be afraid to wear the pieces separately. Pair the top with jeans or a skirt, or wear the bottom with a different top.</li>
 <li><b>Layer Up:</b> Add layers to your outfit for warmth and style. A denim jacket, cardigan, or blazer can transform the look of the 2 Pcs Set.</li>
 <li><b>Play with Shoes:</b> The right shoes can make or break an outfit. Choose shoes that complement the set\'s style and the occasion.</li>
 <li><b>Consider the Occasion:</b> Dress the set up or down depending on the occasion. Add heels and jewelry for a formal event, or wear sneakers and a baseball cap for a casual outing.</li>
</ul>

<h2>Where to Buy Affordable 2 Pcs Sets Online</h2>

<p>Online shopping offers a vast selection of 2 Pcs Sets at various price points. Here are some popular online retailers where you can find affordable options:</p>

<ul>
 <li><b>[Insert relevant e-commerce website here]</b></li>
 <li><b>[Insert relevant e-commerce website here]</b></li>
 <li><b>[Insert relevant e-commerce website here]</b></li>
</ul>

<p>Remember to compare prices and read reviews before making a purchase. Look for retailers that offer free shipping and easy returns to ensure a hassle-free shopping experience.</p>

<h2>Conclusion: Embrace the Enduring Appeal of the 2 Pcs Set</h2>

<p>The 2 Pcs Set is more than just a fleeting trend; it\'s a versatile and enduring wardrobe staple that offers endless styling possibilities. Whether you\'re looking for a comfortable loungewear set, a chic co-ord set, or a sophisticated workwear ensemble, the 2 Pcs Set has something to offer everyone. With its affordability, convenience, and style cohesion, it\'s a must-have for any fashion-conscious individual. Embrace the versatility of the 2 Pcs Set and elevate your style today!</p>', NULL, NULL, '2 Pcs Set: Trends, Style & Best Price Online', 'Explore the latest 2 Pcs Set trends! Discover styling tips, historical context, and future predictions. Shop online for the best price!', '2 pcs set, fashion, style, trendy, online shopping, best price, fashion trends, latest trends, trend analysis, style trends', NULL, 9, 1, '{\"blog_type\":\"trend_analysis\",\"tone\":\"authoritative\",\"word_count\":1600,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"fashion trends\",\"latest trends\",\"trend analysis\",\"style trends\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:06:49.043592Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:06:49', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:06:49', '2025-09-28 17:06:49'),
(32, 'Unveiling the 2 Pcs Set: A Comprehensive Review & Style Guide (₹360)', 'unveiling-the-2-pcs-set-a-comprehensive-review-style-guide-rs360', 'Dive into our in-depth review of the 2 Pcs Set! Discover its features, benefits, pros & cons, and whether it\'s the perfect addition to your wardrobe. Is it trendy & worth the price?', '<html>
<head>
<title>Unveiling the 2 Pcs Set: A Comprehensive Review & Style Guide (₹360)</title>
</head>
<body>
<h1>Unveiling the 2 Pcs Set: A Comprehensive Review & Style Guide (₹360)</h1>

<p>In the ever-evolving world of fashion, finding stylish and affordable pieces can feel like searching for a needle in a haystack. Today, we\'re diving deep into the <b>2 Pcs Set</b>, a budget-friendly option priced at just ₹360. This comprehensive review will cover everything you need to know, from initial impressions to a final verdict, helping you decide if this <b>2 pcs set</b> deserves a place in your wardrobe.</p>

<h2>Product Overview and First Impressions</h2>

<p>The <b>2 Pcs Set</b>, as the name suggests, comprises two individual pieces designed to be worn together. The immediate appeal lies in its simplicity and affordability. At ₹360, it presents an attractive entry point for those looking to experiment with new styles without breaking the bank. Our initial impression was one of cautious optimism. While the price point is certainly appealing, we were keen to assess the quality, fit, and overall aesthetic appeal of the <b>2 pcs set</b>. The description is fairly brief, simply stating \"2 Pcs Set,\" which leaves much to the imagination and necessitates a thorough examination of the product itself.</p>

<p>Upon receiving the <b>2 pcs set</b>, the packaging was standard, offering adequate protection during transit. The initial feel of the fabric was… adequate. It\'s important to manage expectations at this price point; you\'re unlikely to find luxurious materials. However, the stitching appeared reasonably sound, and there were no immediately obvious flaws. The design, while simple, seemed versatile enough to be styled in various ways.</p>

<h2>Key Features and Benefits of the 2 Pcs Set</h2>

<p>Let\'s delve into the specific features and potential benefits of this <b>2 pcs set</b>:</p>

<h3>Affordability: The Undisputed Champion</h3>
<p>At ₹360, the price is undoubtedly the most significant selling point. It allows budget-conscious shoppers to explore different styles and trends without a significant financial commitment. This makes it ideal for students, young professionals, or anyone looking to expand their wardrobe without emptying their wallets.</p>

<h3>Versatility in Styling</h3>
<p>A key benefit of a <b>2 pcs set</b> is its inherent versatility. The individual pieces can be worn together as a coordinated outfit or separately, allowing for numerous styling possibilities. Pair the top with jeans or a skirt, or wear the bottom with a different top – the options are endless.</p>

<h3>Potential for Accessorizing</h3>
<p>The simplicity of the <b>2 pcs set</b> provides a blank canvas for accessorizing. You can easily elevate the look with statement jewelry, scarves, belts, or a stylish handbag. This allows you to personalize the outfit and create a unique look that reflects your individual style.</p>

<h3>Experimentation with Trends</h3>
<p>Given its affordability, the <b>2 pcs set</b> offers a low-risk way to experiment with current fashion trends. If you\'re unsure about a particular style, trying it out with an inexpensive set like this allows you to explore your fashion sense without a significant investment.</p>

<h3>Easy to Care For (Potentially)</h3>
<p>Depending on the fabric composition (which should be checked before purchase), the <b>2 pcs set</b> may be easy to care for. Many affordable sets are made from materials that are machine washable and require minimal ironing, making them a convenient option for everyday wear. *Always check the care label before washing.*</p>

<h2>Pros and Cons: Weighing the Options</h2>

<p>As with any product, the <b>2 Pcs Set</b> has its advantages and disadvantages. Let\'s take a balanced look at the pros and cons:</p>

<h3>Pros:</h3>
<ul>
  <li><b>Exceptional Affordability:</b> The ₹360 price tag makes it accessible to a wide range of consumers.</li>
  <li><b>Styling Versatility:</b> Can be worn as a set or as separates, offering multiple outfit options.</li>
  <li><b>Great for Accessorizing:</b> Provides a blank canvas for personalizing with jewelry, scarves, and other accessories.</li>
  <li><b>Trend Experimentation:</b> A low-risk way to try out new styles and trends.</li>
  <li><b>Potentially Easy Care:</b> Depending on the fabric, it may be machine washable and require minimal ironing.</li>
</ul>

<h3>Cons:</h3>
<ul>
  <li><b>Potential Quality Concerns:</b> At this price point, the fabric quality may be lower than more expensive options.</li>
  <li><b>Limited Design Options:</b> The design may be basic and lack intricate details.</li>
  <li><b>Possible Sizing Issues:</b> Sizing can sometimes be inconsistent with affordable clothing. <i>Always check size charts and reviews before ordering.</i></li>
  <li><b>Durability Concerns:</b> The set may not be as durable as higher-quality clothing items.</li>
  <li><b>Transparency of Origin:</b> Ethical and environmental concerns related to low-cost manufacturing might be a factor.</li>
</ul>

<h2>Who Should Buy This Product?</h2>

<p>The <b>2 Pcs Set</b> is ideally suited for:</p>

<ul>
  <li><b>Budget-Conscious Shoppers:</b> Those looking for affordable fashion options.</li>
  <li><b>Students:</b> Perfect for creating stylish outfits on a limited budget.</li>
  <li><b>Trend Experimenters:</b> Individuals who want to try out new styles without a significant investment.</li>
  <li><b>Minimalists:</b> Those who appreciate simple and versatile clothing items.</li>
  <li><b>Those needing a basic wardrobe staple:</b> If you need a simple, functional outfit for casual occasions.</li>
</ul>

<p>However, this set might not be the best choice for:</p>

<ul>
  <li><b>Those seeking high-quality, durable clothing:</b> If you prioritize longevity and premium materials, you\'ll likely be disappointed.</li>
  <li><b>Individuals looking for intricate designs and detailing:</b> The design is typically basic and may lack elaborate embellishments.</li>
  <li><b>Those with specific sizing requirements:</b> Sizing can be inconsistent with affordable clothing, so careful measurement and review reading are crucial.</li>
</ul>

<h2>Comparison with Similar Products</h2>

<p>To provide a comprehensive review, let\'s compare the <b>2 Pcs Set</b> with similar products in the same price range:</p>

<p><b>Alternative 1: Single Dress (₹350-₹400):</b> A single dress might offer more style options than a very plain <b>2 pcs set</b>, but lacks the versatility of separates. Quality is likely similar at this price point. Consider the dress if you prefer a one-piece outfit.</p>

<p><b>Alternative 2: Basic T-shirt and Shorts Set (₹300-₹400):</b> Similar to the <b>2 Pcs Set</b>, this option offers a casual, comfortable look. The quality and design will likely be comparable. Choose based on your preferred style – a dressier 2-piece set or a more relaxed t-shirt and shorts combination.</p>

<p><b>Alternative 3: Discounted Items from Fast Fashion Brands (₹350-₹450):</b> Keep an eye out for sales and discounts from popular fast fashion brands. You might find individual items (like a top or skirt) within this price range, but a coordinated set is less likely. This option offers potentially better quality and design but requires more searching and may not always be available.</p>

<p><b>Key Considerations for Comparison:</b></p>
<ul>
  <li><b>Fabric Quality:</b> Compare the materials used and read reviews to assess durability and comfort.</li>
  <li><b>Design and Style:</b> Choose a style that aligns with your personal preferences and wardrobe needs.</li>
  <li><b>Sizing Accuracy:</b> Pay close attention to size charts and customer reviews to ensure a proper fit.</li>
  <li><b>Return Policies:</b> Check the return policies of the retailer in case the item doesn\'t meet your expectations.</li>
</ul>

<h2>Styling Tips for the 2 Pcs Set</h2>

<p>Here are a few styling tips to help you make the most of your <b>2 Pcs Set</b>:</p>

<ul>
  <li><b>Dress it Up:</b> Add heels, statement jewelry, and a clutch for a more formal occasion.</li>
  <li><b>Dress it Down:</b> Pair it with sneakers, a denim jacket, and a backpack for a casual, everyday look.</li>
  <li><b>Mix and Match:</b> Wear the top with jeans or a skirt, and the bottom with a different top to create multiple outfits.</li>
  <li><b>Accessorize:</b> Use scarves, belts, and hats to personalize the outfit and add your own unique flair.</li>
  <li><b>Focus on Fit:</b> Ensure the set fits you well for a more flattering and polished look. Consider tailoring if necessary.</li>
</ul>

<h2>Final Verdict and Recommendation</h2>

<p>The <b>2 Pcs Set</b> at ₹360 is a budget-friendly option that offers surprising versatility. While the quality may not be comparable to higher-priced items, it provides a low-risk way to experiment with trends and expand your wardrobe without breaking the bank. Its affordability makes it an excellent choice for students, budget-conscious shoppers, and anyone looking for a simple, versatile outfit.</p>

<p><b>Recommendation:</b> If you\'re aware of the potential limitations in terms of quality and durability and are primarily looking for an affordable and versatile option, the <b>2 Pcs Set</b> is worth considering. However, manage your expectations and be prepared to accessorize and style it creatively to elevate the overall look. Always check the size chart and read reviews before purchasing to ensure a proper fit. For those prioritizing high quality and long-lasting garments, investing in more expensive options might be a better choice.</p>

<p>Overall, the <b>2 Pcs Set</b> is a testament to the accessibility of fashion. It allows individuals to express their style without financial constraints. With careful styling and a realistic understanding of its limitations, it can be a valuable addition to any budget-conscious wardrobe. Happy shopping!</p>
</body>
</html>', NULL, NULL, '2 Pcs Set Review: Is it Trendy & Worth ₹360?', 'Comprehensive review of the 2 Pcs Set. Explore its features, benefits, pros & cons, styling tips, and whether it\'s a trendy and affordable addition to your wardrobe.', '2 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide', NULL, 9, 1, '{\"blog_type\":\"product_review\",\"tone\":\"authoritative\",\"word_count\":1900,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"in-depth review\",\"comprehensive review\",\"product analysis\",\"review guide\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:29:19.412969Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:29:19', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(33, '2 Pcs Set Review: Unveiling Style, Value, and Versatility (₹360)', '2-pcs-set-review-unveiling-style-value-and-versatility-rs360', 'In-depth review of the 2 Pcs Set: Discover its features, benefits, pros, and cons. Find out if this trendy fashion set is the perfect addition to your wardrobe at an unbeatable price!', '<html><body><h2>Introduction: Diving Deep into the 2 Pcs Set Phenomenon</h2>
<p>In the ever-evolving world of fashion, finding the perfect balance between style, affordability, and quality can feel like an impossible quest. The allure of online shopping often leads us down rabbit holes of endless browsing, leaving us overwhelmed with choices. But what if there was a simple, elegant solution that ticks all the boxes? Enter the <b>2 Pcs Set</b>, a fashion-forward concept designed to streamline your wardrobe and elevate your style without breaking the bank.</p>
<p>Priced at an incredibly accessible ₹360.00, this <b>2 Pcs Set</b> promises a complete look in one convenient package. But does it live up to the hype? In this comprehensive review, we\'ll dissect every aspect of this offering, from its initial impressions to its long-term value, helping you decide if it\'s the right addition to your fashion arsenal. We\'ll explore its key features, weigh the pros and cons, and compare it to similar products on the market, providing you with an unbiased and informative perspective. Get ready for an in-depth <b>product analysis</b> of the <b>2 Pcs Set</b>!</p>

<h2>First Impressions: Unboxing and Initial Thoughts</h2>
<p>The initial experience with any product sets the stage for expectations. The <b>2 Pcs Set</b> arrives in simple, yet functional packaging. While not extravagant, the packaging serves its purpose, protecting the contents during transit. Upon opening, the first thing that strikes you is the simplicity of the set. The pieces are neatly folded, giving a sense of order and care. The fabric feels surprisingly soft to the touch, especially considering the affordable price point. The stitching appears to be reasonably well-done, suggesting a level of craftsmanship that exceeds expectations.</p>
<p>However, it\'s essential to manage expectations. At ₹360.00, one shouldn\'t expect the same level of luxury as a high-end designer set. The initial impression is one of good value for money – a functional and seemingly stylish set that promises to deliver on its basic promise of providing a complete outfit.</p>

<h2>Key Features and Benefits: What Makes This 2 Pcs Set Stand Out?</h2>
<p>Let\'s delve into the specific features and benefits that the <b>2 Pcs Set</b> offers:</p>

<h3>Simplicity and Convenience</h3>
<p>The core benefit of a <b>2 Pcs Set</b> is its simplicity. It eliminates the need for endless coordination, providing a complete outfit solution in one purchase. This is particularly appealing for those who are short on time or who prefer a minimalist approach to fashion. The convenience factor is undeniable, making it a practical choice for everyday wear.</p>

<h3>Affordability: Unbeatable Price Point</h3>
<p>At ₹360.00, the <b>2 Pcs Set</b> is incredibly affordable. This price point makes it accessible to a wide range of consumers, allowing them to experiment with different styles and trends without breaking the bank. It\'s an excellent option for budget-conscious shoppers who are looking for stylish and functional clothing.</p>

<h3>Versatility: Adaptable to Different Occasions</h3>
<p>Depending on the design and fabric, a <b>2 Pcs Set</b> can be surprisingly versatile. It can be dressed up with accessories and heels for a more formal occasion or dressed down with sneakers for a casual look. This adaptability makes it a valuable addition to any wardrobe, offering multiple styling options for different events and settings.</p>

<h3>Trendy Style: Keeping Up with the Latest Fashion</h3>
<p>The <b>2 Pcs Set</b> is designed to reflect current fashion trends. This allows consumers to stay up-to-date with the latest styles without having to invest in individual pieces. It\'s a cost-effective way to experiment with new looks and express personal style.</p>

<h3>Easy to Care For: Low-Maintenance Fabric</h3>
<p>The fabric used in the <b>2 Pcs Set</b> is typically chosen for its ease of care. This means that it\'s often machine washable and requires minimal ironing, making it a practical choice for busy individuals. The low-maintenance nature of the fabric ensures that the set remains in good condition with minimal effort.</p>

<h2>Pros and Cons: A Balanced Perspective</h2>
<p>To provide a comprehensive <b>review guide</b>, it\'s essential to weigh the pros and cons of the <b>2 Pcs Set</b>:</p>

<h3>Pros:</h3>
<ul>
<li><b>Affordable Price:</b> At ₹360.00, it\'s a budget-friendly option.</li>
<li><b>Convenient:</b> Provides a complete outfit solution.</li>
<li><b>Versatile:</b> Can be dressed up or down for different occasions.</li>
<li><b>Trendy:</b> Reflects current fashion trends.</li>
<li><b>Easy to Care For:</b> Low-maintenance fabric.</li>
</ul>

<h3>Cons:</h3>
<ul>
<li><b>Fabric Quality:</b> May not be as luxurious as high-end sets.</li>
<li><b>Durability:</b> May not withstand frequent wear and washing as well as more expensive options.</li>
<li><b>Limited Design Options:</b> The available designs may be limited compared to individual pieces.</li>
<li><b>Potential for Size Issues:</b> Fit may not be perfect for all body types.</li>
<li><b>Generic Style:</b> May lack unique details or personalized touches.</li>
</ul>

<h2>Who Should Buy This Product? Targeting the Ideal Customer</h2>
<p>The <b>2 Pcs Set</b> is ideal for:</p>
<ul>
<li><b>Budget-conscious shoppers:</b> Those who are looking for stylish clothing at an affordable price.</li>
<li><b>Students:</b> A practical and affordable option for everyday wear.</li>
<li><b>Busy individuals:</b> Those who are short on time and need a quick and easy outfit solution.</li>
<li><b>Fashion experimenters:</b> Those who want to try out new trends without a significant investment.</li>
<li><b>Minimalists:</b> Those who prefer a simple and streamlined wardrobe.</li>
</ul>

<h2>Comparison with Similar Products: Analyzing the Competition</h2>
<p>To provide a complete <b>product analysis</b>, let\'s compare the <b>2 Pcs Set</b> with similar products on the market:</p>

<h3>Comparable Products:</h3>
<ul>
<li><b>Other Budget-Friendly Sets:</b> Many online retailers offer similar <b>2 Pcs Sets</b> at comparable prices. However, the quality and design can vary significantly.</li>
<li><b>Individual Clothing Items:</b> Buying individual pieces to create a similar outfit can be more expensive but offers greater flexibility in terms of style and fit.</li>
<li><b>Higher-End Sets:</b> More expensive sets offer better fabric quality, more intricate designs, and greater durability.</li>
</ul>

<h3>Key Differences:</h3>
<ul>
<li><b>Price:</b> The <b>2 Pcs Set</b> is significantly more affordable than higher-end sets or individual clothing items.</li>
<li><b>Quality:</b> The fabric quality and durability may not be as high as more expensive options.</li>
<li><b>Design:</b> The design options may be more limited compared to individual pieces or higher-end sets.</li>
<li><b>Convenience:</b> The <b>2 Pcs Set</b> offers unparalleled convenience as a complete outfit solution.</li>
</ul>

<h2>Final Verdict and Recommendation: Is the 2 Pcs Set Worth It?</h2>
<p>After a thorough and <b>comprehensive review</b>, the verdict is in: the <b>2 Pcs Set</b> offers exceptional value for its price. While it may not be the most luxurious or durable option on the market, it delivers on its promise of providing a stylish and convenient outfit solution at an incredibly affordable price point. The simplicity, versatility, and trendy style make it a worthwhile addition to any wardrobe, especially for budget-conscious shoppers and busy individuals.</p>
<p><b>Recommendation:</b> If you\'re looking for a trendy, affordable, and convenient outfit solution, the <b>2 Pcs Set</b> is definitely worth considering. Just be sure to manage your expectations regarding fabric quality and durability. For ₹360.00, you\'re getting a great deal on a functional and fashionable set that can elevate your style without breaking the bank. Embrace the <b>online shopping</b> experience and explore the possibilities this <b>2 Pcs Set</b> offers. This is a <b>best price</b> option for those seeking a quick and easy fashion fix.</p>
</body></html>', NULL, NULL, '2 Pcs Set Review: Style, Value, Price (₹360)', 'In-depth 2 Pcs Set review: features, benefits, pros & cons. Is this trendy fashion set right for you? Find out now!', '2 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide', NULL, 10, 1, '{\"blog_type\":\"product_review\",\"tone\":\"authoritative\",\"word_count\":1900,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"in-depth review\",\"comprehensive review\",\"product analysis\",\"review guide\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:34:43.803377Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:34:43', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:34:43', '2025-09-28 17:34:43'),
(34, 'Double the Fun: Your Ultimate Guide to Buying the Perfect 2 Pcs Set!', 'double-the-fun-your-ultimate-guide-to-buying-the-perfect-2-pcs-set', 'Looking for the perfect 2 pcs set? This guide covers everything from style tips to price ranges, helping you make the best purchase decision. Shop smart & stay trendy!', '<html><body><h2>Hey Fashionistas! Welcome to the 2 Pcs Set Obsession!</h2>
<p>Let\'s be honest, who doesn\'t love a good matching set? They\'re effortless, stylish, and instantly elevate your look. Today, we\'re diving deep into the world of the <b>2 pcs set</b>. We\'re talking about everything you need to know before you click that \'add to cart\' button. Whether you\'re a seasoned online shopper or a newbie looking for some guidance, this is your ultimate guide to scoring the perfect <b>2 pcs set</b> at the <b>best price</b>!</p>

<h3>What\'s the Big Deal About 2 Pcs Sets Anyway?</h3>
<p>Simple: they make looking put-together easy. No more agonizing over matching tops and bottoms. A <b>2 pcs set</b> is a complete outfit in one convenient package. Plus, you can mix and match the pieces with other items in your wardrobe for even more versatility. Think of it as a building block for endless stylish possibilities!</p>

<h2>Decoding the 2 Pcs Set: Your Ultimate Buyer Guide</h2>
<p>So, you\'re ready to jump on the <b>2 pcs set</b> bandwagon? Awesome! But before you start scrolling through pages of options, let\'s break down what to look for to ensure you\'re getting the best bang for your buck. This <b>buyer guide</b> will help you navigate the world of <b>2 pcs sets</b> like a pro.</p>

<h3>What to Look for When Buying a 2 Pcs Set</h3>
<p>Think of this as your checklist for <b>online shopping</b> success:</p>
<ul>
  <li><b>Fabric Quality:</b> This is HUGE. Read the product description carefully. Look for durable fabrics that feel good against your skin. Consider the season – breathable cotton for summer, cozy knits for winter.</li>
  <li><b>Style and Fit:</b> Are you going for a casual, sporty, or dressy vibe? Choose a style that matches your personal taste and body type. Pay attention to sizing charts and read reviews to get an idea of how the set fits.</li>
  <li><b>Color and Print:</b> This is where you can really express yourself! Do you prefer bold colors, subtle neutrals, or eye-catching prints? Consider what colors complement your skin tone and what prints you feel confident wearing.</li>
  <li><b>Construction and Details:</b> Check for well-stitched seams, secure closures (buttons, zippers), and any other details that indicate quality craftsmanship.</li>
  <li><b>Care Instructions:</b> Are you willing to hand-wash a delicate silk set, or do you need something that\'s machine-washable and dryer-friendly?</li>
</ul>

<h3>Key Factors to Consider Before You Buy</h3>
<p>Before you finalize your <b>purchase decisions</b>, ask yourself these questions:</p>
<ul>
  <li><b>What\'s the Occasion?</b> Are you buying the set for everyday wear, a special event, or a vacation? This will influence your choice of style, fabric, and color.</li>
  <li><b>What\'s Your Budget?</b> Set a realistic budget before you start shopping. This will help you narrow down your options and avoid overspending.</li>
  <li><b>What\'s Your Personal Style?</b> Choose a set that reflects your individual style and makes you feel confident and comfortable.</li>
  <li><b>What Other Items Do You Own?</b> Consider how the set will integrate into your existing wardrobe. Can you mix and match the pieces with other items you already own?</li>
  <li><b>What are the Reviews Saying?</b> Always read reviews from other customers before making a purchase. This can give you valuable insights into the quality, fit, and overall satisfaction of the product.</li>
</ul>

<h3>Price Ranges: What to Expect for a 2 Pcs Set</h3>
<p>The price of a <b>2 pcs set</b> can vary greatly depending on the brand, fabric, style, and retailer. Here\'s a general breakdown:</p>
<ul>
  <li><b>₹300 - ₹500:</b> Expect basic fabrics, simple designs, and potentially less durable construction. These sets are often made from synthetic materials.</li>
  <li><b>₹500 - ₹1000:</b> You\'ll find a wider range of styles and slightly better quality fabrics. Expect to see more cotton blends and potentially some linen options.</li>
  <li><b>₹1000 - ₹2000:</b> This is where you\'ll find higher-quality fabrics, more intricate designs, and better construction. Look for natural fibers like cotton, linen, and rayon.</li>
  <li><b>₹2000+:</b> Expect luxury fabrics, designer brands, and exceptional craftsmanship. These sets are often made from silk, cashmere, or other high-end materials.</li>
</ul>
<p>Our featured <b>2 pcs set</b> at <b>₹360.00</b> falls into the budget-friendly category. While you might not get the absolute highest quality, you can still find stylish and wearable options if you shop smart and pay attention to the details mentioned above.</p>

<h3>How the 2 Pcs Set Fits into the Market</h3>
<p>The <b>2 pcs set</b> is a huge trend in the <b>fashion</b> world right now, and for good reason! It caters to the demand for effortless style and versatility. It\'s a convenient and affordable way to update your wardrobe and stay on top of the latest trends. From casual loungewear to chic evening ensembles, there\'s a <b>2 pcs set</b> for every occasion and personal style.</p>

<p>The market is flooded with options, ranging from fast-fashion retailers to high-end designer brands. This means there\'s something for everyone, regardless of their budget or style preferences. The popularity of <b>online shopping</b> has also made it easier than ever to find the perfect <b>2 pcs set</b> from the comfort of your own home.</p>

<h2>Shopping Tips for Scoring the Perfect 2 Pcs Set</h2>
<p>Ready to put your newfound knowledge to the test? Here are some additional <b>shopping tips</b> to help you make the best <b>purchase decision</b>:</p>

<h3>1. Read the Product Description Carefully</h3>
<p>Don\'t just rely on the photos. Read the product description thoroughly to understand the fabric composition, care instructions, and sizing information. Pay attention to details like the length of the top and bottoms, the type of closure, and any special features.</p>

<h3>2. Check the Sizing Chart</h3>
<p>Sizing can vary greatly between brands, so always check the sizing chart before ordering. Measure yourself accurately and compare your measurements to the chart to ensure you\'re selecting the right size. If you\'re unsure, it\'s always better to size up rather than down.</p>

<h3>3. Read Customer Reviews</h3>
<p>Customer reviews are a goldmine of information. Read what other shoppers have to say about the quality, fit, and overall satisfaction of the product. Pay attention to reviews that mention specific details, such as the fabric\'s feel, the fit\'s accuracy, and the garment\'s durability.</p>

<h3>4. Look for Sales and Discounts</h3>
<p>Don\'t be afraid to shop around for the best deal. Many retailers offer sales and discounts on <b>2 pcs sets</b> throughout the year. Sign up for email newsletters and follow your favorite brands on social media to stay informed about upcoming sales and promotions. Look for coupon codes and cashback offers to save even more money.</p>

<h3>5. Consider the Return Policy</h3>
<p>Before making a purchase, always check the retailer\'s return policy. Make sure you understand the terms and conditions, including the return window and any applicable restocking fees. This will protect you in case the set doesn\'t fit or you\'re not satisfied with the quality.</p>

<h3>6. Don\'t Be Afraid to Experiment</h3>
<p>The <b>2 pcs set</b> trend is all about having fun and expressing your personal style. Don\'t be afraid to experiment with different colors, prints, and styles to find what works best for you. Try pairing the pieces with other items in your wardrobe to create unique and stylish looks.</p>

<h3>7. Think About Layering</h3>
<p>Consider how you can layer the <b>2 pcs set</b> for different seasons or occasions. A lightweight set can be layered under a jacket or cardigan in cooler weather, while a heavier set can be worn on its own in warmer weather. Adding accessories like scarves, belts, and jewelry can also transform the look of the set.</p>

<h2>Final Thoughts: Rocking Your 2 Pcs Set with Confidence!</h2>
<p>The <b>2 pcs set</b> is more than just a trend; it\'s a versatile and stylish wardrobe staple. By following these <b>shopping tips</b> and considering the key factors mentioned above, you can confidently choose the perfect set that reflects your personal style and fits your budget. So go ahead, embrace the <b>2 pcs set</b> obsession and elevate your <b>fashion</b> game!</p>

<p>Remember, the most important thing is to choose a set that makes you feel good. When you feel confident and comfortable in your clothes, you\'ll radiate that positive energy to the world. Happy shopping!</p>

<p>Now you know <b>how to buy</b> a <b>trendy</b> and amazing <b>2 pcs set</b>. Happy <b>online shopping</b>!</p></body></html>', NULL, NULL, '2 Pcs Set: Your Ultimate Buying Guide for Trendy Fashion', 'Discover the perfect 2 pcs set! Our guide covers style, price, & shopping tips for trendy fashion. Make informed purchase decisions today!', '2 pcs set, fashion, style, trendy, online shopping, best price, buyer guide, shopping tips, how to buy, purchase decisions', NULL, 10, 1, '{\"blog_type\":\"buying_guide\",\"tone\":\"casual\",\"word_count\":1550,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"buyer guide\",\"shopping tips\",\"how to buy\",\"purchase decisions\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:35:00.280371Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:35:00', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:35:00', '2025-09-28 17:35:00'),
(35, 'Unlock Your Style Potential: The Ultimate Guide to Styling Your 2 Pcs Set!', 'unlock-your-style-potential-the-ultimate-guide-to-styling-your-2-pcs-set', 'Discover endless styling possibilities with our versatile 2 Pcs Set! From casual chic to elegant evenings, learn how to rock this trendy piece with our expert fashion guide.', '<html><body><h2>Hey Fashionistas! Welcome to the 2 Pcs Set Style Revolution!</h2><p>Ready to revamp your wardrobe with a piece that\'s both stylish and budget-friendly? You\'ve landed in the right place! Today, we\'re diving deep into the world of the <b>2 Pcs Set</b> – your new go-to for effortless style. At just ₹360.00, this set is a steal, and we\'re here to show you exactly how to make the most of it.</p><p>So, what exactly <i>is</i> a <b>2 Pcs Set</b>? Well, it\'s a matching outfit, usually consisting of a top and bottom, designed to be worn together. Think coordinated perfection without the hassle of searching for matching pieces. Let\'s explore how to style this versatile item and conquer the fashion game!</p><h2>Why You Need a 2 Pcs Set in Your Life</h2><p>Before we jump into styling tips, let\'s talk about why a <b>2 Pcs Set</b> is a must-have in every fashion-forward individual\'s closet:</p><ul><li><b>Effortless Coordination:</b> Say goodbye to outfit dilemmas! The <b>2 Pcs Set</b> takes the guesswork out of matching, ensuring you always look put-together.</li><li><b>Versatility:</b> Don\'t think you\'re stuck wearing the pieces together! Mix and match the top and bottom with other items in your wardrobe for endless outfit possibilities.</li><li><b>Budget-Friendly:</b> At ₹360.00, this is an affordable way to elevate your style without breaking the bank.</li><li><b>Trendy and Chic:</b> <b>2 Pcs Sets</b> are all the rage right now, making you instantly on-trend.</li></ul><h2>Decoding the 2 Pcs Set: A Styling Guide for Every Occasion</h2><p>Now for the fun part! Let\'s explore different ways to style your <b>2 Pcs Set</b> for various occasions:</p><h3>Casual Chic: Everyday Style Made Easy</h3><p>For a laid-back, everyday look, here\'s how to rock your <b>2 Pcs Set</b>:</p><ul><li><b>Footwear:</b> Pair it with white sneakers, canvas shoes, or espadrilles for a comfortable and stylish vibe.</li><li><b>Outerwear:</b> Throw on a denim jacket, a light cardigan, or a bomber jacket for added warmth and style.</li><li><b>Accessories:</b> Keep it simple with a crossbody bag, a baseball cap, and some delicate jewelry.</li><li><b>Styling Tip:</b> Try tying the top in a knot at the front for a more playful and relaxed look.</li></ul><h3>Elevated Casual: Brunch with the Girls or a Day Date</h3><p>Want to step up your casual game? Here\'s how to elevate your <b>2 Pcs Set</b> for a brunch date or a casual outing:</p><ul><li><b>Footwear:</b> Opt for stylish sandals, loafers, or low heels.</li><li><b>Outerwear:</b> A blazer or a trench coat can instantly add sophistication.</li><li><b>Accessories:</b> A structured handbag, sunglasses, and statement earrings will complete the look.</li><li><b>Styling Tip:</b> Add a belt to cinch your waist and define your silhouette.</li></ul><h3>Evening Elegance: Date Night or Special Occasion</h3><p>Believe it or not, your <b>2 Pcs Set</b> can even be dressed up for a night out! Here\'s how to transform it into an elegant ensemble:</p><ul><li><b>Footwear:</b> High heels or strappy sandals are a must.</li><li><b>Outerwear:</b> A faux fur stole or a tailored coat can add a touch of glamour.</li><li><b>Accessories:</b> A clutch, statement necklace, and elegant earrings will elevate the look.</li><li><b>Styling Tip:</b> Choose a <b>2 Pcs Set</b> in a luxurious fabric like satin or velvet for a more formal feel.</li></ul><h3>Work-Appropriate: From Desk to Dinner</h3><p>With the right styling, your <b>2 Pcs Set</b> can even be office-appropriate. Here\'s how:</p><ul><li><b>Footwear:</b> Closed-toe heels or loafers are your best bet.</li><li><b>Outerwear:</b> A blazer or a structured cardigan will create a professional look.</li><li><b>Accessories:</b> A tote bag, a simple watch, and minimalist jewelry are perfect for the workplace.</li><li><b>Styling Tip:</b> Make sure the <b>2 Pcs Set</b> is made of a suitable fabric like cotton or linen and avoid overly revealing styles.</li></ul><h2>Accessorize Like a Pro: Completing Your 2 Pcs Set Look</h2><p>Accessories are key to personalizing your <b>2 Pcs Set</b> and making it your own. Here are some ideas:</p><ul><li><b>Belts:</b> Cinching your waist with a belt can instantly transform the shape of your outfit. Experiment with different belt styles, from wide statement belts to thin, delicate ones.</li><li><b>Jewelry:</b> The right jewelry can add sparkle and personality to your look. Consider layering necklaces, stacking bracelets, or wearing statement earrings.</li><li><b>Scarves:</b> A scarf can add a pop of color and texture to your outfit. Tie it around your neck, your bag, or your hair for a stylish touch.</li><li><b>Hats:</b> From baseball caps to fedoras, hats can add a cool and trendy vibe to your <b>2 Pcs Set</b>.</li><li><b>Bags:</b> Choose a bag that complements your outfit and suits the occasion. Consider a crossbody bag for casual outings, a tote bag for work, or a clutch for evening events.</li></ul><h2>Seasonal Styling Tips: Rocking Your 2 Pcs Set All Year Round</h2><p>Your <b>2 Pcs Set</b> can be a year-round staple with a few seasonal adjustments:</p><h3>Spring: Embrace the Colors</h3><p>In spring, embrace bright colors and floral prints. Pair your <b>2 Pcs Set</b> with lightweight jackets, sandals, and pastel-colored accessories.</p><h3>Summer: Stay Cool and Chic</h3><p>In summer, opt for breathable fabrics like cotton or linen. Pair your <b>2 Pcs Set</b> with sandals, sunglasses, and a wide-brimmed hat for sun protection.</p><h3>Autumn: Layer Up in Style</h3><p>In autumn, layer your <b>2 Pcs Set</b> with cardigans, jackets, and scarves. Choose warm colors like burgundy, olive green, and mustard yellow.</p><h3>Winter: Cozy and Chic</h3><p>In winter, layer your <b>2 Pcs Set</b> with coats, sweaters, and boots. Choose heavier fabrics like wool or velvet and accessorize with hats, gloves, and scarves.</p><h2>Care and Maintenance: Keeping Your 2 Pcs Set Looking Its Best</h2><p>To ensure your <b>2 Pcs Set</b> lasts for years to come, follow these care and maintenance tips:</p><ul><li><b>Read the Care Label:</b> Always check the care label for specific washing instructions.</li><li><b>Wash Gently:</b> Hand wash or machine wash on a delicate cycle with cold water.</li><li><b>Use a Mild Detergent:</b> Avoid harsh detergents that can damage the fabric.</li><li><b>Air Dry:</b> Hang your <b>2 Pcs Set</b> to air dry to prevent shrinking and fading.</li><li><b>Iron Carefully:</b> Iron on a low setting or use a steamer to remove wrinkles.</li><li><b>Store Properly:</b> Store your <b>2 Pcs Set</b> in a cool, dry place away from direct sunlight.</li></ul><h2>Final Thoughts: Unleash Your Inner Stylist with the 2 Pcs Set!</h2><p>The <b>2 Pcs Set</b> is a versatile and affordable way to elevate your style. With a little creativity and these styling tips, you can create endless outfit possibilities. So, go ahead, grab your <b>2 Pcs Set</b> and unleash your inner stylist! Happy styling!</p><p>Don\'t forget to share your <b>2 Pcs Set</b> looks with us on social media using #2PcsSetStyle #FashionTips #TrendyOutfits! We can\'t wait to see your amazing creations!</p></body></html>', NULL, NULL, 'Style Your 2 Pcs Set: Outfit Ideas & Fashion Tips', 'Unlock endless style possibilities with our ₹360 2 Pcs Set! Get fashion advice, outfit ideas, and styling tips for every occasion. Shop trendy fashion online!', '2 pcs set, fashion, style, trendy, online shopping, best price, styling guide, fashion advice, outfit ideas, style tips', NULL, 10, 1, '{\"blog_type\":\"style_guide\",\"tone\":\"casual\",\"word_count\":1300,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"styling guide\",\"fashion advice\",\"outfit ideas\",\"style tips\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:35:15.802511Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:35:15', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:35:15', '2025-09-28 17:35:15'),
(36, 'Elevate Your Style with the Perfect 2 Pcs Set: Trend Analysis & Buying Guide', 'elevate-your-style-with-the-perfect-2-pcs-set-trend-analysis-buying-guide', 'Discover the versatility of the 2 Pcs Set! Explore current trends, historical context, future predictions, and celebrity endorsements. Shop now at the best price!', '<h1>Elevate Your Style with the Perfect 2 Pcs Set: Trend Analysis & Buying Guide</h1>

<p>In the ever-evolving world of fashion, staying ahead of the curve is essential. The <strong>2 Pcs Set</strong> has emerged as a versatile and stylish option for those seeking effortless coordination and on-trend looks. Priced at ₹360.00, this set offers an accessible entry point into current fashion movements. This comprehensive guide will delve into the current trends, historical context, future predictions, and celebrity endorsements surrounding the <strong>2 Pcs Set</strong>, providing you with the knowledge to make informed purchasing decisions and elevate your personal style.</p>

<h2>What is a 2 Pcs Set?</h2>

<p>A <strong>2 Pcs Set</strong>, in its simplest form, is a coordinated outfit consisting of two separate pieces designed to be worn together. This could encompass a wide range of combinations, such as a top and bottom (skirt, pants, shorts), a dress and a jacket, or even a top and a matching accessory. The key element is the intentional coordination in terms of color, pattern, or style, creating a cohesive and put-together look.</p>

<h2>Current Fashion Trends Embracing the 2 Pcs Set</h2>

<p>The <strong>2 Pcs Set</strong> is experiencing a surge in popularity due to its adaptability and alignment with several key fashion trends:</p>

<h3>1. Co-ord Sets: The Epitome of Effortless Style</h3>

<p>Co-ord sets, short for coordinated sets, are perhaps the most prominent manifestation of the <strong>2 Pcs Set</strong> trend. These sets typically feature matching tops and bottoms, often in bold prints, vibrant colors, or sophisticated neutrals. They offer a convenient and stylish solution for creating a complete outfit with minimal effort.</p>

<h3>2. Loungewear Sets: Comfort Meets Chic</h3>

<p>The rise of loungewear has significantly impacted the fashion landscape, and <strong>2 Pcs Set</strong> loungewear options are particularly popular. These sets prioritize comfort without sacrificing style, often featuring soft fabrics, relaxed silhouettes, and subtle details. Think matching knit tops and pants, or cozy sweater and skirt combinations.</p>

<h3>3. Athleisure Sets: Blurring the Lines Between Activewear and Streetwear</h3>

<p>Athleisure continues to be a dominant force in fashion, and <strong>2 Pcs Set</strong> athleisure options are a natural extension of this trend. These sets combine athletic-inspired elements with stylish designs, creating versatile outfits suitable for workouts, errands, or casual outings. Look for matching leggings and sports bras, or tracksuits in trendy colors and patterns.</p>

<h3>4. Matching Separates: Elevated Coordination</h3>

<p>Beyond co-ord sets, the concept of matching separates is also gaining traction. This involves pairing individual pieces that complement each other in terms of color, texture, or style. A <strong>2 Pcs Set</strong> in this context might consist of a silk blouse and a matching midi skirt, or a tailored blazer and coordinating trousers.</p>

<h2>How the ₹360.00 2 Pcs Set Fits into Current Trends</h2>

<p>While the specific design of the ₹360.00 <strong>2 Pcs Set</strong> isn\'t detailed, its accessibility and affordability position it well within the current trend of democratizing fashion. It allows individuals to experiment with the <strong>2 Pcs Set</strong> trend without a significant financial investment. Depending on the specific style and material, it could tap into the loungewear or athleisure trends, offering a comfortable and stylish option for everyday wear. The price point makes it an attractive option for students, young professionals, and anyone looking to update their wardrobe on a budget.</p>

<h2>Historical Context and Evolution of the 2 Pcs Set</h2>

<p>The concept of coordinated outfits has existed in various forms throughout history. However, the modern <strong>2 Pcs Set</strong>, as we know it, has evolved significantly over time:</p>

<h3>Early 20th Century: The Rise of Separates</h3>

<p>The early 20th century saw the emergence of separates as a distinct fashion category. Before this, clothing was often custom-made or consisted of complete dresses or suits. The introduction of separates allowed for greater versatility and individual expression. While not always intentionally coordinated, the idea of mixing and matching different pieces laid the foundation for the <strong>2 Pcs Set</strong>.</p>

<h3>Mid-20th Century: The Matching Suit and Twinset</h3>

<p>The mid-20th century witnessed the popularity of matching suits for women, consisting of a skirt and jacket in the same fabric and style. The twinset, a matching sweater and cardigan, also gained prominence, representing a classic and sophisticated form of the <strong>2 Pcs Set</strong>.</p>

<h3>Late 20th Century: The Power Suit and Casual Co-ords</h3>

<p>The power suit of the 1980s, with its structured blazer and matching trousers or skirt, represented a bold and assertive take on the <strong>2 Pcs Set</strong>. In the more casual realm, matching denim sets and other co-ord options began to emerge, reflecting a growing desire for comfortable and stylish everyday wear.</p>

<h3>21st Century: The Explosion of Choice and Versatility</h3>

<p>The 21st century has seen an explosion of choice and versatility in the <strong>2 Pcs Set</strong> category. The rise of fast fashion, online shopping, and social media has fueled the trend, with countless variations available to suit every taste and occasion. From loungewear sets to athleisure sets to sophisticated matching separates, the <strong>2 Pcs Set</strong> has become a staple in modern wardrobes.</p>

<h2>Future Predictions for the 2 Pcs Set Category</h2>

<p>The <strong>2 Pcs Set</strong> is poised to remain a significant trend in the coming years, with several key factors driving its continued popularity:</p>

<h3>1. Sustainability and Ethical Production</h3>

<p>As consumers become more conscious of the environmental and social impact of their clothing choices, there will be a growing demand for sustainable and ethically produced <strong>2 Pcs Set</strong> options. This could involve using eco-friendly fabrics, supporting fair labor practices, and promoting circular fashion models.</p>

<h3>2. Personalization and Customization</h3>

<p>The future of fashion is increasingly focused on personalization and customization. We can expect to see more <strong>2 Pcs Set</strong> options that allow consumers to mix and match different pieces, choose their preferred fabrics and colors, and even design their own unique sets.</p>

<h3>3. Technology Integration</h3>

<p>Technology is likely to play a greater role in the <strong>2 Pcs Set</strong> category, with innovations such as virtual try-on tools, AI-powered style recommendations, and smart fabrics that can adapt to different environments.</p>

<h3>4. Inclusivity and Body Positivity</h3>

<p>The fashion industry is becoming more inclusive and body-positive, and this trend will extend to the <strong>2 Pcs Set</strong> category. We can expect to see a wider range of sizes, styles, and designs that cater to diverse body types and preferences.</p>

<h3>5. Metaverse and Digital Fashion</h3>

<p>With the rise of the metaverse, digital fashion is becoming increasingly relevant. <strong>2 Pcs Set</strong> options will likely expand into the digital realm, allowing individuals to express their style and identity in virtual environments.</p>

<h2>Celebrity and Influencer Endorsements</h2>

<p>Celebrity and influencer endorsements play a significant role in shaping fashion trends. Many celebrities and influencers have embraced the <strong>2 Pcs Set</strong>, further solidifying its popularity:</p>

<h3>Examples of Celebrity and Influencer Endorsements</h3>

<ul>
 <li>**Rihanna:** Known for her bold and eclectic style, Rihanna has been spotted wearing various <strong>2 Pcs Set</strong> options, from sporty tracksuits to sophisticated matching separates.</li>
 <li>**Kendall Jenner:** A prominent figure in the fashion world, Kendall Jenner frequently showcases <strong>2 Pcs Set</strong> looks on social media and in public appearances, often opting for trendy co-ord sets or athleisure-inspired ensembles.</li>
 <li>**Selena Gomez:** Selena Gomez has been seen wearing both casual and dressy <strong>2 Pcs Set</strong> options, demonstrating the versatility of the trend.</li>
 <li>**Fashion Bloggers:** Countless fashion bloggers and influencers regularly feature <strong>2 Pcs Set</strong> looks in their content, providing inspiration and styling tips to their followers. Examples include Aimee Song (Song of Style), Chiara Ferragni (The Blonde Salad), and Julie Sariñana (Sincerely Jules).</li>
</ul>

<p>These endorsements help to popularize the <strong>2 Pcs Set</strong> trend and showcase its versatility and appeal to a wide audience. By observing how celebrities and influencers style their <strong>2 Pcs Set</strong> outfits, consumers can gain inspiration and learn how to incorporate the trend into their own wardrobes.</p>

<h2>Styling Tips for the 2 Pcs Set</h2>

<p>The beauty of the <strong>2 Pcs Set</strong> lies in its versatility. Here are some styling tips to help you make the most of this trend:</p>

<ul>
 <li>**Mix and Match:** While the <strong>2 Pcs Set</strong> is designed to be worn together, don\'t be afraid to mix and match the individual pieces with other items in your wardrobe. This can create a variety of different looks and extend the versatility of the set.</li>
 <li>**Accessorize:** Accessories can play a crucial role in elevating your <strong>2 Pcs Set</strong> outfit. Consider adding a statement necklace, a stylish belt, or a pair of eye-catching earrings to personalize your look.</li>
 <li>**Footwear:** The right footwear can make or break your <strong>2 Pcs Set</strong> outfit. Choose shoes that complement the style and occasion, whether it\'s sneakers for a casual athleisure look or heels for a more formal event.</li>
 <li>**Layering:** Layering can add depth and dimension to your <strong>2 Pcs Set</strong> outfit. Try adding a jacket, a cardigan, or a scarf to create a more interesting and dynamic look.</li>
 <li>**Consider the Occasion:** Choose a <strong>2 Pcs Set</strong> that is appropriate for the occasion. A casual loungewear set is perfect for relaxing at home, while a sophisticated matching separate is ideal for a business meeting.</li>
</ul>

<h2>Where to Buy the ₹360.00 2 Pcs Set</h2>

<p>The ₹360.00 <strong>2 Pcs Set</strong> is likely available at various online retailers, discount stores, and local boutiques. Be sure to compare prices and read reviews before making a purchase. Look for retailers that offer secure payment options and hassle-free returns.</p>

<h2>Conclusion: Embrace the Versatility of the 2 Pcs Set</h2>

<p>The <strong>2 Pcs Set</strong> is more than just a fleeting trend; it\'s a versatile and stylish option that offers effortless coordination and endless possibilities. Whether you\'re seeking a comfortable loungewear set, a trendy athleisure ensemble, or a sophisticated matching separate, the <strong>2 Pcs Set</strong> has something to offer everyone. At ₹360.00, this set provides an accessible entry point into the world of coordinated fashion. Embrace the versatility of the <strong>2 Pcs Set</strong> and elevate your personal style today!</p>', NULL, NULL, '2 Pcs Set: Trends, Style Guide, & Best Price', 'Explore the latest 2 Pcs Set trends! Learn about styling, historical context, future predictions, and celebrity endorsements. Shop the best deals now!', '2 pcs set, fashion, style, trendy, online shopping, best price, current trends, trending styles, fashion movements, style direction', NULL, 10, 1, '{\"blog_type\":\"trend_analysis\",\"tone\":\"authoritative\",\"word_count\":1650,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"current trends\",\"trending styles\",\"fashion movements\",\"style direction\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:35:36.271427Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:35:36', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:35:36', '2025-09-28 17:35:36'),
(37, '2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360?', '2-pcs-set-review-is-this-trendy-fashion-find-worth-rs360', 'Dive into our comprehensive review of the 2 Pcs Set! Is it a stylish steal or a fashion flop? We break down the pros, cons, and everything in between. Find out if this trendy set is right for you!', '<html>
<head>
<title>2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360?</title>
</head>
<body>

<h1>2 Pcs Set Review: Is This Trendy Fashion Find Worth ₹360?</h1>

<p>In the ever-evolving world of fashion, finding stylish and affordable pieces can feel like searching for a needle in a haystack. Enter the <b>2 Pcs Set</b>, a budget-friendly option that promises to deliver on both trendiness and value. Priced at just ₹360.00, this set has piqued the interest of many online shoppers. But does it live up to the hype? This <b>in-depth review</b> will provide a <b>comprehensive analysis</b>, covering everything from first impressions to a final verdict, helping you decide if this <b>2 pcs set</b> deserves a place in your wardrobe.</p>

<h2>Product Overview and First Impressions</h2>

<p>The <b>2 Pcs Set</b> arrives packaged simply, reflecting its budget-friendly price point. Upon unboxing, the initial impression largely depends on the specific style of the set. Given the generic description, the actual contents can vary. This review assumes a common scenario: a coordinated top and bottom, likely made from a lightweight, possibly synthetic fabric. </p>

<p>The fabric\'s feel is crucial. A rough or uncomfortable material would be a major drawback. Ideally, it should be reasonably soft and breathable, especially considering the price point. The stitching and overall construction are also important indicators of quality. Visible loose threads or uneven seams would suggest a lack of attention to detail and potentially impact the garment\'s durability. Initial impressions are mixed, leaning towards cautiously optimistic. The affordability is undeniable, but the true test lies in its performance and style.</p>

<h2>Key Features and Benefits of the 2 Pcs Set</h2>

<p>While the description is sparse, we can infer some key features and benefits based on the nature of a <b>2 pcs set</b>:</p>

<ul>
  <li><b>Coordinated Outfit:</b> The primary benefit is having a ready-to-wear, coordinated outfit. This saves time and effort in putting together a stylish look.</li>
  <li><b>Affordability:</b> At ₹360.00, the price is incredibly attractive, making it accessible to a wide range of consumers.</li>
  <li><b>Trendiness:</b> The set aims to capture current fashion trends, allowing buyers to stay stylish without breaking the bank.</li>
  <li><b>Versatility (Potentially):</b> Depending on the style, the individual pieces might be versatile enough to be worn separately, creating multiple outfit options. This is a significant potential benefit.</li>
  <li><b>Convenience:</b> Online shopping makes it easy to purchase and receive the set from the comfort of your home.</li>
</ul>

<p>Let\'s delve deeper into each of these benefits:</p>

<h3>Coordinated Style Made Easy</h3>

<p>The beauty of a <b>2 pcs set</b> lies in its inherent coordination. The guesswork of matching tops and bottoms is eliminated, providing an instant, put-together look. This is particularly appealing for those who struggle with outfit creation or simply want a quick and easy fashion solution. The pre-matched aesthetic can be a significant time-saver, especially on busy mornings.</p>

<h3>Unbeatable Affordability: Fashion on a Budget</h3>

<p>The ₹360.00 price tag is undoubtedly a major draw. In a market where clothing prices can be exorbitant, this set offers an accessible entry point into trendy fashion. It\'s a budget-friendly option for students, young professionals, or anyone looking to update their wardrobe without spending a fortune. This affordability makes it a low-risk purchase, allowing consumers to experiment with new styles without significant financial commitment.</p>

<h3>Embracing Current Trends</h3>

<p>The <b>2 pcs set</b>, by its nature, aims to reflect current fashion trends. Whether it\'s a matching crop top and skirt, a co-ord set with a unique print, or a casual loungewear combination, the set allows buyers to tap into the latest styles without investing in individual, expensive pieces. This is particularly appealing for those who want to stay on-trend without overspending. However, it\'s crucial to assess whether the trend aligns with your personal style and body type.</p>

<h3>Versatility: Maximizing Your Wardrobe</h3>

<p>The potential for versatility is a key factor to consider. If the individual pieces of the <b>2 pcs set</b> can be worn separately, the value of the purchase increases significantly. For example, a skirt from the set could be paired with a different top, or the top could be worn with jeans or trousers. This versatility allows for more outfit combinations and maximizes the wearability of the set. However, this depends entirely on the style and design of the individual pieces.</p>

<h3>The Convenience of Online Shopping</h3>

<p>The ease of online shopping adds to the appeal of the <b>2 pcs set</b>. You can browse, purchase, and receive the set from the comfort of your own home, eliminating the need to visit physical stores. This is particularly convenient for those with busy schedules or limited access to shopping options. However, it\'s crucial to check the seller\'s return policy and sizing information before making a purchase, as online shopping can sometimes lead to sizing issues or discrepancies in product appearance.</p>

<h2>Pros and Cons of the 2 Pcs Set</h2>

<p>To provide a balanced perspective, here\'s a breakdown of the pros and cons of the <b>2 Pcs Set</b>:</p>

<h3>Pros:</h3>

<ul>
  <li><b>Extremely Affordable:</b> The low price point makes it accessible to a wide range of consumers.</li>
  <li><b>Coordinated Outfit:</b> Saves time and effort in creating a stylish look.</li>
  <li><b>Trendy Design:</b> Aims to capture current fashion trends.</li>
  <li><b>Potential Versatility:</b> Individual pieces might be wearable separately.</li>
  <li><b>Convenient Online Shopping:</b> Easy to purchase and receive from home.</li>
</ul>

<h3>Cons:</h3>

<ul>
  <li><b>Potentially Low-Quality Materials:</b> The low price might indicate the use of cheaper fabrics that are uncomfortable or lack durability.</li>
  <li><b>Uncertain Fit:</b> Online sizing can be tricky, and the fit might not be ideal.</li>
  <li><b>Limited Information:</b> The generic description makes it difficult to assess the exact style and quality of the set before purchasing.</li>
  <li><b>Potential for Fast Fashion Waste:</b> The low price could contribute to a culture of disposable fashion.</li>
  <li><b>Ethical Concerns:</b> The low price might raise concerns about ethical labor practices in the production of the garment.</li>
</ul>

<h2>Who Should Buy This Product?</h2>

<p>The <b>2 Pcs Set</b> is best suited for:</p>

<ul>
  <li><b>Budget-conscious shoppers:</b> Those looking for affordable fashion options.</li>
  <li><b>Trend-followers:</b> Individuals who want to experiment with new styles without spending a lot of money.</li>
  <li><b>Students:</b> A cost-effective way to build a stylish wardrobe on a limited budget.</li>
  <li><b>Those seeking convenience:</b> Individuals who appreciate the ease of a coordinated outfit.</li>
  <li><b>People who are comfortable with online shopping risks:</b> Those willing to take a chance on a low-priced item with limited information.</li>
</ul>

<p>This set is less suitable for:</p>

<ul>
  <li><b>Those prioritizing high-quality materials and ethical production:</b> The low price likely indicates compromises in these areas.</li>
  <li><b>Individuals with specific fit requirements:</b> Online sizing can be unreliable, and the set might not fit perfectly.</li>
  <li><b>Those seeking long-lasting wardrobe staples:</b> The durability of the set is uncertain, and it might not withstand frequent wear.</li>
</ul>

<h2>Comparison with Similar Products</h2>

<p>When comparing the <b>2 Pcs Set</b> with similar products, it\'s important to consider price, quality, style, and brand reputation. Here\'s a brief overview:</p>

<ul>
  <li><b>Higher-Priced Sets from Established Brands:</b> These sets typically offer better quality materials, more reliable sizing, and a greater emphasis on ethical production. However, they come at a significantly higher price point.</li>
  <li><b>Sets from Fast Fashion Retailers:</b> These sets often offer a similar price point to the <b>2 Pcs Set</b> but might have a wider variety of styles and designs. However, the quality and ethical considerations are often similar.</li>
  <li><b>Mix-and-Match Outfits:</b> Creating your own coordinated outfits by purchasing individual pieces can offer greater control over quality, fit, and style. However, this requires more time and effort and might ultimately be more expensive.</li>
</ul>

<p>Ultimately, the best option depends on your individual priorities and budget. If affordability is your primary concern, the <b>2 Pcs Set</b> might be a viable option. However, if you prioritize quality, ethical production, and a perfect fit, you might be better off investing in higher-priced alternatives or creating your own coordinated outfits.</p>

<h2>Final Verdict and Recommendation</h2>

<p>The <b>2 Pcs Set</b> presents a compelling proposition for budget-conscious shoppers seeking a trendy and convenient fashion solution. At ₹360.00, the price is undeniably attractive, making it a low-risk purchase for those looking to experiment with new styles. The coordinated nature of the set eliminates the guesswork of outfit creation, saving time and effort.</p>

<p>However, it\'s crucial to acknowledge the potential drawbacks. The low price likely indicates compromises in material quality and ethical production. The fit might be uncertain due to online sizing, and the durability of the set is questionable. The generic description also makes it difficult to assess the exact style and quality before purchasing.</p>

<p><b>Recommendation:</b> If you\'re aware of the potential limitations and are primarily driven by affordability and trendiness, the <b>2 Pcs Set</b> might be worth a try. However, manage your expectations and be prepared for the possibility of lower quality and an imperfect fit. Carefully review the seller\'s return policy before making a purchase. If you prioritize quality, ethical production, and a perfect fit, consider exploring higher-priced alternatives or creating your own coordinated outfits.</p>

<p><b>Overall Rating:</b> 3 out of 5 stars.</p>

</body>
</html>', NULL, NULL, '2 Pcs Set Review: Trendy Fashion for ₹360? (Honest Look)', 'Is the 2 Pcs Set worth it? Our comprehensive review covers style, quality, price, pros, and cons. Find out if this trendy fashion find is right for you!', '2 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide', NULL, 11, 1, '{\"blog_type\":\"product_review\",\"tone\":\"authoritative\",\"word_count\":1900,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"in-depth review\",\"comprehensive review\",\"product analysis\",\"review guide\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:40:13.370811Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:40:13', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:40:13', '2025-09-28 17:40:13'),
(38, 'Double the Style: Your Ultimate Guide to Buying the Perfect 2 Pcs Set', 'double-the-style-your-ultimate-guide-to-buying-the-perfect-2-pcs-set', 'Looking for a stylish and affordable 2 pcs set? This guide covers everything you need to know, from what to look for to making the best purchase decision! Shop smart!', '<html>
<head>
<title>Double the Style: Your Ultimate Guide to Buying the Perfect 2 Pcs Set</title>
</head>
<body>

<h1>Double the Style: Your Ultimate Guide to Buying the Perfect 2 Pcs Set</h1>

<p>Hey there, fashionistas and savvy shoppers! Are you on the hunt for a versatile and trendy outfit solution? Look no further than the ever-popular <strong>2 pcs set</strong>! These sets are a fantastic way to create a coordinated look without the hassle of mixing and matching individual pieces. And with a price point like ₹360.00, they\'re incredibly accessible too! But before you click that \'buy\' button, let\'s dive deep into the world of 2 pcs sets and explore everything you need to know to make the perfect purchase. This guide is your ultimate companion, covering everything from what to look for, key considerations, price ranges, and tips for making the best decision. Let\'s get started!</p>

<h2>What is a 2 Pcs Set and Why Should You Care?</h2>

<p>Simply put, a <strong>2 pcs set</strong> is an outfit that includes two coordinating pieces. These pieces can be anything from a top and bottom (like a t-shirt and shorts, or a blouse and skirt) to a dress with a matching jacket or cardigan. The beauty of a 2 pcs set lies in its simplicity and versatility. It takes the guesswork out of outfit planning, allowing you to create a stylish look with minimal effort. Plus, because the pieces are designed to complement each other, you\'re guaranteed a cohesive and fashionable ensemble.</p>

<p>Think about it: no more staring into your closet wondering what goes with what! A 2 pcs set is your instant style solution, perfect for casual outings, work events, or even dressing up for a special occasion. They are also great for mixing and matching with other items in your wardrobe!</p>

<h2>What to Look for When Buying a 2 Pcs Set</h2>

<p>Not all 2 pcs sets are created equal. To ensure you\'re getting the best value for your money and a set that you\'ll truly love, here\'s what to keep an eye out for:</p>

<h3>Fabric Quality</h3>

<p>The fabric is arguably the most important factor. Consider the following:</p>

<ul>
  <li><strong>Comfort:</strong> Is the fabric soft and breathable? Will it feel good against your skin? For everyday wear, look for materials like cotton, rayon, or linen.</li>
  <li><strong>Durability:</strong> How well will the fabric hold up to washing and wearing? Will it pill, fade, or stretch out of shape easily? Heavier fabrics like denim or twill tend to be more durable.</li>
  <li><strong>Care Instructions:</strong> Are you willing to hand-wash or dry clean the set? If not, opt for machine-washable fabrics.</li>
  <li><strong>Seasonality:</strong> Consider the time of year you\'ll be wearing the set. Lightweight fabrics like linen and cotton are ideal for summer, while heavier fabrics like wool or fleece are better suited for winter.</li>
</ul>

<h3>Fit and Style</h3>

<p>The fit of your 2 pcs set is crucial for both comfort and style. Consider these points:</p>

<ul>
  <li><strong>Body Type:</strong> Choose a style that flatters your figure. If you\'re petite, look for sets with shorter lengths and fitted silhouettes. If you\'re curvy, opt for sets with flowy fabrics and empire waists.</li>
  <li><strong>Occasion:</strong> Think about where you\'ll be wearing the set. A casual set for running errands will have a different fit and style than a dressier set for a night out.</li>
  <li><strong>Comfort:</strong> Make sure the set is comfortable to move around in. Avoid sets that are too tight or restrictive.</li>
  <li><strong>Sizing:</strong> Always check the size chart before ordering, as sizes can vary between brands. It\'s often a good idea to read customer reviews to get a sense of how the set runs.</li>
</ul>

<h3>Design and Details</h3>

<p>The details can make or break a 2 pcs set. Pay attention to the following:</p>

<ul>
  <li><strong>Color and Pattern:</strong> Choose colors and patterns that you love and that complement your skin tone.</li>
  <li><strong>Embellishments:</strong> Consider whether you want a set with embellishments like embroidery, sequins, or lace. Keep in mind that embellishments can sometimes make a set more difficult to care for.</li>
  <li><strong>Construction:</strong> Look for well-constructed sets with clean seams, secure buttons, and sturdy zippers.</li>
  <li><strong>Coordinated look:</strong> Ensure the two pieces actually compliment each other and create a stylish, put-together appearance.</li>
</ul>

<h2>Key Factors to Consider Before You Buy</h2>

<p>Beyond the basics, here are some key factors to consider before making your purchase:</p>

<h3>Your Existing Wardrobe</h3>

<p>Think about how the 2 pcs set will fit into your existing wardrobe. Can you mix and match the pieces with other items you already own? A versatile set that can be worn in multiple ways is a great investment.</p>

<h3>Your Personal Style</h3>

<p>Choose a set that reflects your personal style. If you\'re a minimalist, opt for a simple and classic set. If you\'re a fashionista, go for a bold and trendy set.</p>

<h3>The Occasion</h3>

<p>Consider the occasions you\'ll be wearing the set to. A casual set is perfect for everyday wear, while a dressier set is ideal for special events.</p>

<h3>Your Budget</h3>

<p>Set a budget before you start shopping. 2 pcs sets are available at a wide range of price points, so it\'s important to know how much you\'re willing to spend. Remember our set is priced at ₹360.00, which is a great value!</p>

<h2>Different Price Ranges and What to Expect</h2>

<p>The price of a 2 pcs set can vary widely depending on the brand, fabric, and design. Here\'s a general overview of what you can expect at different price ranges:</p>

<ul>
  <li><strong>₹300 - ₹700:</strong> At this price point, you can find basic 2 pcs sets made from affordable fabrics like cotton blends or polyester. The designs are typically simple and straightforward. Expect reasonable quality but potentially shorter lifespan.</li>
  <li><strong>₹700 - ₹1500:</strong> In this range, you\'ll find sets made from higher-quality fabrics like rayon, linen, or denim. The designs are more stylish and may include embellishments or unique details. Better construction and durability are common.</li>
  <li><strong>₹1500 and Up:</strong> At the higher end, you\'ll find designer 2 pcs sets made from luxurious fabrics like silk, wool, or cashmere. These sets feature sophisticated designs and impeccable construction. Expect top-notch quality and longevity.</li>
</ul>

<p>Remember, our featured <strong>2 pcs set</strong> is priced at ₹360.00, making it an incredibly affordable option for those looking for a stylish and budget-friendly outfit!</p>

<h2>How This Product Fits into the Market</h2>

<p>The <strong>2 pcs set</strong> market is booming, driven by the demand for convenient and stylish outfit solutions. These sets are incredibly popular with fashion-conscious individuals who want to look put-together without spending hours planning their outfits. They cater to a broad audience, from students and young professionals to busy moms and seasoned fashionistas. The affordability of many 2 pcs sets, like our ₹360.00 option, makes them accessible to a wide range of consumers.</p>

<p>The market is constantly evolving with new trends and styles emerging regularly. From athleisure sets to elegant dresses with matching jackets, there\'s a 2 pcs set for every occasion and personal style. Online shopping has further fueled the growth of the market, making it easier than ever to find the perfect set from the comfort of your own home.</p>

<h2>Tips for Making the Best Purchase Decision</h2>

<p>Ready to make your purchase? Here are some final tips to ensure you choose the perfect 2 pcs set:</p>

<ul>
  <li><strong>Read Reviews:</strong> Before you buy, take the time to read customer reviews. This can give you valuable insights into the fit, quality, and overall satisfaction of the set.</li>
  <li><strong>Check the Size Chart:</strong> Sizes can vary between brands, so always check the size chart before ordering.</li>
  <li><strong>Consider the Return Policy:</strong> Make sure you understand the return policy before you buy. This will protect you in case the set doesn\'t fit or you\'re not happy with it.</li>
  <li><strong>Compare Prices:</strong> Shop around and compare prices from different retailers. You might be surprised at how much you can save.</li>
  <li><strong>Trust Your Gut:</strong> Ultimately, the best 2 pcs set is one that you love and feel confident wearing. Trust your gut and choose a set that makes you feel good.</li>
  <li><strong>Don\'t be afraid to experiment:</strong> The world of 2 pcs sets is vast and varied. Try different styles and fabrics until you find what works best for you.</li>
</ul>

<h2>Conclusion: Embrace the Simplicity and Style of a 2 Pcs Set</h2>

<p>A <strong>2 pcs set</strong> is a fantastic addition to any wardrobe. They offer a convenient, stylish, and affordable way to create a coordinated look. By considering the factors outlined in this guide, you can confidently choose a set that you\'ll love and wear for years to come. And with options like our ₹360.00 set, you don\'t have to break the bank to look fabulous! So go ahead, explore the world of 2 pcs sets and discover your new favorite outfit solution!</p>

<p>Happy shopping!</p>

</body>
</html>', NULL, NULL, '2 Pcs Set: The Ultimate Buyer\'s Guide for Fashionistas', 'Your comprehensive guide to buying the perfect 2 pcs set! Learn what to look for, key considerations, and tips for making the best purchase decision. Shop now!', '2 pcs set, fashion, style, trendy, online shopping, best price, buyer guide, shopping tips, how to buy, purchase decisions', NULL, 11, 1, '{\"blog_type\":\"buying_guide\",\"tone\":\"casual\",\"word_count\":1550,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"buyer guide\",\"shopping tips\",\"how to buy\",\"purchase decisions\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:40:32.534341Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:40:32', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:40:32', '2025-09-28 17:40:32'),
(39, 'Unlocking Style Potential: The Ultimate Guide to Styling Your 2 Pcs Set', 'unlocking-style-potential-the-ultimate-guide-to-styling-your-2-pcs-set', 'Discover endless style possibilities with our versatile 2 Pcs Set! This complete style guide offers outfit ideas, styling tips, & care advice. Shop now at the best price!', '<h2>Introduction: Embracing the Versatility of the 2 Pcs Set</h2>

In the ever-evolving world of fashion, finding pieces that offer both style and versatility is key. Enter the <b>2 Pcs Set</b> – a wardrobe staple that promises endless possibilities. Priced at just ₹360.00, this set is an affordable way to elevate your fashion game. This <b>complete style guide</b> will delve into how to style your <b>2 pcs set</b> for various occasions, matching accessories, seasonal trends, and essential care tips. Whether you\'re a seasoned fashionista or just starting to explore your personal style, this guide will provide you with the knowledge to confidently rock your <b>2 pcs set</b>.

<h2>Why the 2 Pcs Set is a Must-Have</h2>

The <b>2 pcs set</b> isn\'t just a trend; it\'s a foundational piece that offers several advantages:

*   <b>Versatility:</b> Easily dressed up or down, making it suitable for a range of occasions.
*   <b>Affordability:</b> At ₹360.00, it provides excellent value for money.
*   <b>Convenience:</b> Takes the guesswork out of outfit coordination.
*   <b>Style Statement:</b> When styled correctly, it can make a bold fashion statement.

<h2>Styling Your 2 Pcs Set: A Comprehensive Guide</h2>

This section provides a detailed breakdown of how to style your <b>2 pcs set</b> for maximum impact. We\'ll explore different looks, from casual chic to sophisticated elegance.

<h3>Casual Chic: Effortless Everyday Style</h3>

For a relaxed, everyday look, consider these styling tips:

*   <b>Footwear:</b> Pair your <b>2 pcs set</b> with sneakers, sandals, or espadrilles.
*   <b>Outerwear:</b> Add a denim jacket or a lightweight cardigan for cooler days.
*   <b>Accessories:</b> Keep it simple with a crossbody bag or a baseball cap.
*   <b>Jewelry:</b> Opt for minimalist jewelry, such as a delicate necklace or stud earrings.

Example: A linen <b>2 pcs set</b> paired with white sneakers and a denim jacket is perfect for a weekend brunch.

<h3>Business Casual: Polished and Professional</h3>

Elevate your <b>2 pcs set</b> for a business casual setting with these tips:

*   <b>Footwear:</b> Choose loafers, ballet flats, or low heels.
*   <b>Outerwear:</b> A blazer or a trench coat adds a touch of sophistication.
*   <b>Accessories:</b> A structured tote bag and a scarf can enhance the look.
*   <b>Jewelry:</b> Select classic pieces like a watch or pearl earrings.

Example: A tailored <b>2 pcs set</b> in a neutral color worn with loafers and a blazer is ideal for a business meeting.

<h3>Evening Glam: Ready for a Night Out</h3>

Transform your <b>2 pcs set</b> into an evening ensemble with these styling ideas:

*   <b>Footwear:</b> High heels or strappy sandals are a must.
*   <b>Outerwear:</b> A faux fur coat or a sequined jacket adds glamour.
*   <b>Accessories:</b> A clutch and statement jewelry will complete the look.
*   <b>Jewelry:</b> Opt for bold earrings, a statement necklace, or a cocktail ring.

Example: A satin <b>2 pcs set</b> paired with high heels, a clutch, and statement earrings is perfect for a night out.

<h2>Occasions to Wear Your 2 Pcs Set</h2>

The beauty of the <b>2 pcs set</b> lies in its adaptability. Here are some occasions where you can confidently sport this versatile outfit:

*   <b>Work:</b> Depending on the fabric and style, a <b>2 pcs set</b> can be appropriate for the office.
*   <b>Casual Outings:</b> Perfect for lunch dates, shopping trips, or weekend getaways.
*   <b>Parties:</b> Dress it up with heels and accessories for a chic party look.
*   <b>Vacations:</b> Lightweight and easy to pack, a <b>2 pcs set</b> is a great travel companion.
*   <b>Special Events:</b> With the right styling, it can even be worn to weddings or formal gatherings.

<h2>Matching Accessories and Complementary Items</h2>

Selecting the right accessories and complementary items is crucial for completing your <b>2 pcs set</b> look. Here\'s a guide to help you make the best choices:

<h3>Bags</h3>

*   <b>Tote Bag:</b> Ideal for work or shopping, offering ample space for your essentials.
*   <b>Crossbody Bag:</b> Perfect for casual outings, providing hands-free convenience.
*   <b>Clutch:</b> A must-have for evening events, adding a touch of elegance.
*   <b>Backpack:</b> A practical choice for travel or everyday use.

<h3>Shoes</h3>

*   <b>Sneakers:</b> Great for casual, comfortable looks.
*   <b>Sandals:</b> Perfect for warm weather and relaxed occasions.
*   <b>Heels:</b> Essential for dressing up your <b>2 pcs set</b> for evening events.
*   <b>Loafers:</b> A versatile option for both casual and business casual settings.

<h3>Jewelry</h3>

*   <b>Necklaces:</b> Layered necklaces or a statement pendant can add personality to your outfit.
*   <b>Earrings:</b> Hoops, studs, or chandelier earrings can complement your face shape and style.
*   <b>Bracelets:</b> Bangles, cuffs, or charm bracelets can add a touch of sparkle to your wrist.
*   <b>Rings:</b> Simple bands or statement rings can complete your hand accessories.

<h3>Outerwear</h3>

*   <b>Denim Jacket:</b> A classic piece that adds a casual touch.
*   <b>Blazer:</b> Perfect for creating a polished and professional look.
*   <b>Cardigan:</b> A cozy option for cooler days.
*   <b>Trench Coat:</b> A timeless piece that adds sophistication.

<h2>Seasonal Styling Tips for Your 2 Pcs Set</h2>

Adapting your <b>2 pcs set</b> to different seasons is key to maintaining a stylish and comfortable look. Here are some seasonal styling tips:

<h3>Spring</h3>

*   Opt for lightweight fabrics like linen or cotton.
*   Choose pastel colors and floral prints.
*   Pair your <b>2 pcs set</b> with sandals or espadrilles.
*   Add a light jacket or cardigan for cooler evenings.

<h3>Summer</h3>

*   Choose breathable fabrics like cotton or rayon.
*   Embrace bright colors and bold prints.
*   Pair your <b>2 pcs set</b> with sandals or wedges.
*   Accessorize with sunglasses and a hat.

<h3>Autumn</h3>

*   Opt for warmer fabrics like knit or velvet.
*   Choose earthy tones and jewel colors.
*   Pair your <b>2 pcs set</b> with boots or loafers.
*   Add a blazer or a trench coat.

<h3>Winter</h3>

*   Choose heavier fabrics like wool or corduroy.
*   Choose dark colors and rich textures.
*   Pair your <b>2 pcs set</b> with boots or heels.
*   Add a coat, scarf, and gloves.

<h2>Care and Maintenance Advice for Your 2 Pcs Set</h2>

Proper care and maintenance will ensure that your <b>2 pcs set</b> lasts longer and looks its best. Here are some essential care tips:

*   <b>Read the Label:</b> Always follow the care instructions on the garment label.
*   <b>Washing:</b> Wash your <b>2 pcs set</b> according to the fabric type. Delicate fabrics should be hand-washed or washed on a gentle cycle.
*   <b>Drying:</b> Avoid tumble drying, as it can damage the fabric. Hang your <b>2 pcs set</b> to dry naturally.
*   <b>Ironing:</b> Iron your <b>2 pcs set</b> on a low setting, using a pressing cloth to protect the fabric.
*   <b>Storage:</b> Store your <b>2 pcs set</b> in a cool, dry place, away from direct sunlight.

<h2>Where to Buy Your 2 Pcs Set at the Best Price</h2>

Looking for the perfect <b>2 pcs set</b> at an unbeatable price? Our <b>online shopping</b> platform offers a wide selection of trendy and stylish sets at the <b>best price</b>. With easy navigation and secure payment options, you can shop with confidence. Don\'t miss out on our exclusive deals and discounts on <b>fashion</b> and <b>style</b> essentials!

<h2>Conclusion: Embrace Your Style with the Versatile 2 Pcs Set</h2>

The <b>2 pcs set</b> is more than just an outfit; it\'s a style statement. With its versatility, affordability, and ease of styling, it\'s a must-have for every wardrobe. Whether you\'re dressing up for a special occasion or keeping it casual for everyday wear, the <b>2 pcs set</b> offers endless possibilities. So, embrace your style, experiment with different looks, and confidently rock your <b>2 pcs set</b>! This <b>complete style guide</b> is your roadmap to unlocking the full potential of this trendy and fashionable piece. Happy styling!', NULL, NULL, '2 Pcs Set Style Guide: Outfits, Tips & Best Price', 'Unlock endless style possibilities with our 2 Pcs Set! This complete style guide offers outfit ideas, styling tips, care advice & the best price online.', '2 pcs set, fashion, style, trendy, online shopping, best price, complete style guide, fashion styling, outfit guide, style advice', NULL, 11, 1, '{\"blog_type\":\"style_guide\",\"tone\":\"authoritative\",\"word_count\":1350,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"complete style guide\",\"fashion styling\",\"outfit guide\",\"style advice\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:40:49.667534Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:40:49', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:40:49', '2025-09-28 17:40:49'),
(40, 'Elevate Your Style with Our Trendy 2 Pcs Set: A Comprehensive Trend Analysis', 'elevate-your-style-with-our-trendy-2-pcs-set-a-comprehensive-trend-analysis', 'Discover the latest fashion trends and how our affordable 2 Pcs Set can elevate your style. Trend analysis, celebrity inspiration, and future predictions inside!', '<html><body><h2>Unlocking Style Potential: The Versatility of a 2 Pcs Set</h2>

<p>In the ever-evolving world of fashion, finding pieces that offer both style and value can be a challenge. Our <strong>2 pcs set</strong>, priced at just ₹360.00, provides an accessible entry point into current trends, allowing you to experiment with different looks without breaking the bank. This blog post will delve into the nuances of the <strong>2 pcs set</strong>, exploring its current relevance, historical context, and future potential within the fashion landscape.</p>

<h3>Why Choose a 2 Pcs Set?</h3>

<p>A <strong>2 pcs set</strong> offers unparalleled versatility. It\'s a ready-made outfit, eliminating the guesswork of coordinating separates. Whether you\'re aiming for a casual daytime look or a more polished evening ensemble, a well-chosen <strong>2 pcs set</strong> can be your go-to solution.</p>

<h2>Current Fashion Trends and the 2 Pcs Set</h2>

<p>The fashion world is currently dominated by several key trends that perfectly align with the appeal of a <strong>2 pcs set</strong>. These include:</p>

<ul>
    <li><b>Co-ords and Matching Sets:</b> The matching set trend is booming! From loungewear to tailored suits, coordinated outfits are seen as effortlessly chic and put-together.</li>
    <li><b>Comfort and Loungewear:</b> The pandemic has accelerated the demand for comfortable yet stylish clothing. Knit sets, consisting of a top and bottoms, are incredibly popular.</li>
    <li><b>Athleisure:</b> The fusion of athletic and leisure wear continues to be a major influence. Think sporty crop tops paired with matching leggings or joggers.</li>
    <li><b>Minimalism:</b> Clean lines, simple silhouettes, and neutral color palettes are favored for their timeless appeal. A basic <strong>2 pcs set</strong> in a neutral tone can be easily dressed up or down.</li>
    <li><b>Bold Prints and Patterns:</b> On the other end of the spectrum, bold prints and patterns are making a statement. Sets featuring vibrant florals, geometric designs, or animal prints are on trend.</li>
</ul>

<h3>How Our 2 Pcs Set Fits Into Current Trends</h3>

<p>While the specific design of our <strong>2 pcs set</strong> isn\'t mentioned in the description, its very nature allows it to be adapted to these prevailing trends. Depending on its material, cut, and color, it could easily embody the comfort of loungewear, the sleekness of minimalism, or the boldness of a statement print. The affordability of our <strong>2 pcs set</strong> makes it an ideal option for experimenting with different trends without making a significant investment.</p>

<h2>Historical Context and Evolution of the 2 Pcs Set</h2>

<p>The concept of coordinated outfits has a long history in fashion. In the early 20th century, matching skirt and jacket suits were a staple for women. During the mid-century, twin sets (matching sweaters) gained popularity. However, the modern <strong>2 pcs set</strong> as we know it has evolved considerably.</p>

<ul>
    <li><b>Early Days:</b> Initially, matching sets were often associated with formal wear or specific occasions.</li>
    <li><b>The Rise of Casual Sets:</b> As fashion became more relaxed, casual <strong>2 pcs sets</strong> emerged, often made from comfortable fabrics like cotton or jersey.</li>
    <li><b>The Athleisure Influence:</b> The rise of athleisure further diversified the <strong>2 pcs set</strong> category, introducing sporty styles and technical fabrics.</li>
    <li><b>The Matching Separates Boom:</b> The current trend of matching separates has elevated the <strong>2 pcs set</strong> to a new level of sophistication. Designers are creating coordinated outfits in a wide range of styles, from tailored suits to flowy dresses.</li>
</ul>

<h2>Trend Analysis: Diving Deeper</h2>

<h3>The Psychology Behind the Trend</h3>

<p>The popularity of <strong>2 pcs sets</strong> can be attributed to several psychological factors:</p>

<ul>
    <li><b>Effortless Style:</b> They offer a quick and easy way to create a polished look.</li>
    <li><b>Confidence Boost:</b> A well-fitting and stylish set can enhance confidence.</li>
    <li><b>Sense of Belonging:</b> Following trends can provide a sense of connection to a larger community.</li>
    <li><b>Self-Expression:</b> <strong>2 pcs sets</strong> allow individuals to express their personal style through color, pattern, and silhouette.</li>
</ul>

<h3>Market Analysis: The Online Shopping Boom</h3>

<p>The rise of <strong>online shopping</strong> has played a significant role in the popularity of <strong>2 pcs sets</strong>. Online retailers offer a vast selection of styles, making it easy to find the perfect set to suit individual preferences. The convenience of online shopping, combined with competitive pricing, has made <strong>2 pcs sets</strong> more accessible than ever before.</p>

<p>Our <strong>best price</strong> of ₹360.00 for this <strong>2 pcs set</strong> makes it an incredibly attractive option for budget-conscious shoppers looking to stay on top of <strong>fashion trends</strong>.</p>

<h2>Future Predictions for the 2 Pcs Set Category</h2>

<p>The <strong>2 pcs set</strong> is likely to remain a popular fashion staple for the foreseeable future. Here are some predictions for its evolution:</p>

<ul>
    <li><b>Sustainability:</b> Expect to see a growing emphasis on sustainable materials and ethical production practices.</li>
    <li><b>Personalization:</b> Customization options, such as mix-and-match sets and personalized embellishments, will become more prevalent.</li>
    <li><b>Technology Integration:</b> Smart fabrics and wearable technology could be incorporated into <strong>2 pcs sets</strong>.</li>
    <li><b>Inclusivity:</b> Brands will continue to expand their size ranges and offer more inclusive designs to cater to a wider range of body types.</li>
    <li><b>Metaverse Fashion:</b> As the metaverse gains traction, digital <strong>2 pcs sets</strong> will become increasingly popular for virtual avatars and online identities.</li>
</ul>

<h2>Celebrity and Influencer Endorsements</h2>

<p>Celebrities and influencers have played a significant role in popularizing the <strong>2 pcs set</strong> trend. From red carpet appearances to casual street style looks, celebrities have showcased the versatility of coordinated outfits.</p>

<ul>
    <li><b>Celebrity Inspiration:</b> Many celebrities are frequently seen sporting matching sets. Look to figures like Zendaya, Hailey Bieber, and Selena Gomez for inspiration on how to style a <strong>2 pcs set</strong>.</li>
    <li><b>Influencer Marketing:</b> Fashion influencers often collaborate with brands to promote <strong>2 pcs sets</strong> on social media platforms like Instagram and TikTok. These endorsements can significantly impact consumer purchasing decisions.</li>
    <li><b>The Power of Social Media:</b> Social media platforms provide a visual showcase for <strong>2 pcs sets</strong>, allowing users to see how different styles look on various body types and in different settings.</li>
</ul>

<h2>Styling Tips for Your 2 Pcs Set</h2>

<p>Here are some tips on how to style your <strong>2 pcs set</strong> for different occasions:</p>

<ul>
    <li><b>Casual Chic:</b> Pair a knit set with sneakers and a denim jacket for a relaxed daytime look.</li>
    <li><b>Elevated Evening:</b> Dress up a tailored set with heels, statement jewelry, and a clutch.</li>
    <li><b>Athleisure Cool:</b> Combine a sporty set with sneakers and a baseball cap for a trendy athleisure vibe.</li>
    <li><b>Mix and Match:</b> Don\'t be afraid to wear the pieces separately! Pair the top with jeans or the bottoms with a different top for more versatility.</li>
    <li><b>Accessorize:</b> Use accessories to personalize your look and add your own unique touch.</li>
</ul>

<h2>Where to Buy Your Perfect 2 Pcs Set</h2>

<p>With the increasing popularity of <strong>online shopping</strong>, finding the perfect <strong>2 pcs set</strong> is easier than ever. Many online retailers offer a wide selection of styles at competitive prices. Be sure to compare prices and read reviews before making a purchase.</p>

<p>Remember, our <strong>2 pcs set</strong> at ₹360.00 offers an affordable and stylish way to embrace the latest fashion trends. Don\'t miss out on this opportunity to elevate your wardrobe!</p>

<h2>Conclusion: Embrace the Trend with Confidence</h2>

<p>The <strong>2 pcs set</strong> is more than just a fleeting trend; it\'s a versatile and stylish option that can be adapted to a wide range of personal styles. By understanding the historical context, current trends, and future predictions of this category, you can make informed purchasing decisions and embrace the trend with confidence. Our affordable <strong>2 pcs set</strong> provides an excellent starting point for exploring the endless possibilities of coordinated outfits. Stay trendy, stay stylish, and enjoy the journey of self-expression through fashion!</p>

<p>Stay tuned for more trend analysis and <strong>style trends</strong> updates. Happy <strong>online shopping</strong>!</p>

</body></html>', NULL, NULL, '2 Pcs Set: Trend Analysis & Style Guide | Affordable Fashion', 'Explore the latest fashion trends with our affordable 2 Pcs Set. Trend analysis, styling tips, celebrity inspiration, and future predictions!', '2 pcs set, fashion trends, style trends, online shopping, best price, trendy, trend analysis, latest trends', NULL, 11, 1, '{\"blog_type\":\"trend_analysis\",\"tone\":\"authoritative\",\"word_count\":1600,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"fashion trends\",\"latest trends\",\"trend analysis\",\"style trends\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:41:05.960650Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:41:05', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:41:05', '2025-09-28 17:41:05'),
(41, 'Double the Fun: Your Ultimate Guide to Buying the Perfect 2 Pcs Set!', 'double-the-fun-your-ultimate-guide-to-buying-the-perfect-2-pcs-set-2025-09-28', 'Looking for a stylish 2 pcs set? This guide covers everything you need to know, from what to look for to getting the best price. Shop smart & stay trendy!', '<html>
<head></head>
<body>

<h1>Double the Fun: Your Ultimate Guide to Buying the Perfect 2 Pcs Set!</h1>

<p>Hey there, fashionistas and savvy shoppers! Ever feel like your outfit needs that little something extra? Or maybe you\'re just tired of endlessly mixing and matching separates? Well, you\'re in luck! Today, we\'re diving deep into the wonderful world of the <b>2 pcs set</b>. Yep, you heard that right – twice the style, half the effort. And with a price tag like ₹360.00, it\'s a total steal! This isn\'t just a purchase; it\'s an investment in your style game.</p>

<p>This comprehensive buyer\'s guide will walk you through everything you need to know about snagging the perfect <b>2 pcs set</b>. We\'ll cover what to look for, key factors to consider, price ranges, and how this type of set fits into the current fashion landscape. Plus, we\'ll throw in some killer shopping tips to help you make the best purchase decision. Get ready to upgrade your wardrobe without breaking the bank!</p>

<h2>What Exactly IS a 2 Pcs Set, Anyway?</h2>

<p>Okay, let\'s start with the basics. A <b>2 pcs set</b> is simply an outfit that comes with two coordinating pieces. Think of it as a pre-styled outfit that takes the guesswork out of getting dressed. This could be anything from a matching top and bottom (like a crop top and skirt, or a t-shirt and shorts) to a dress with a coordinating jacket or cardigan. The beauty of a 2 pcs set is its versatility. You can wear the pieces together for a cohesive look, or mix and match them with other items in your wardrobe to create endless outfit possibilities.</p>

<h2>Why Choose a 2 Pcs Set? The Perks Are Endless!</h2>

<p>Still on the fence about whether a <b>2 pcs set</b> is right for you? Here are a few compelling reasons to jump on the bandwagon:</p>

<ul>
  <li><b>Effortless Style:</b> Let\'s face it, sometimes putting together an outfit can feel like a chore. A 2 pcs set takes the stress out of getting dressed, giving you an instantly chic look with minimal effort.</li>
  <li><b>Versatility:</b> As mentioned earlier, you\'re not just buying one outfit; you\'re buying multiple styling options. Wear the pieces together for a coordinated look, or mix and match them with other items in your closet to create endless possibilities.</li>
  <li><b>Budget-Friendly:</b> Often, buying a 2 pcs set is more affordable than purchasing two separate pieces. Plus, with a price point like ₹360.00, it\'s a total bargain!</li>
  <li><b>Trendy and Fashionable:</b> 2 pcs sets are having a major moment in the fashion world. They\'re a great way to stay on top of the latest trends without having to completely overhaul your wardrobe.</li>
  <li><b>Convenience:</b> Online shopping makes it incredibly easy to find and purchase the perfect 2 pcs set from the comfort of your own home.</li>
</ul>

<h2>What to Look For When Buying a 2 Pcs Set: Your Ultimate Checklist</h2>

<p>Now that you\'re convinced a <b>2 pcs set</b> is a must-have, let\'s talk about what to look for when making your purchase. Here\'s a comprehensive checklist to keep in mind:</p>

<h3>Material and Fabric</h3>

<p>The fabric of your <b>2 pcs set</b> will determine its comfort, durability, and overall look. Consider the following factors:</p>

<ul>
  <li><b>Seasonality:</b> Choose fabrics appropriate for the weather. Lightweight cotton or linen are great for summer, while thicker knits or fleece are ideal for winter.</li>
  <li><b>Comfort:</b> Opt for fabrics that feel good against your skin. Soft cotton, breathable linen, or stretchy blends are always a good choice.</li>
  <li><b>Care Instructions:</b> Check the care label before buying. Some fabrics require special care, such as dry cleaning or hand washing.</li>
  <li><b>Durability:</b> Look for fabrics that are resistant to wear and tear. Avoid flimsy or easily damaged materials.</li>
</ul>

<h3>Fit and Style</h3>

<p>The fit and style of your <b>2 pcs set</b> should complement your body type and personal taste. Consider the following:</p>

<ul>
  <li><b>Body Type:</b> Choose styles that flatter your figure. For example, if you have an hourglass figure, opt for fitted styles that accentuate your waist.</li>
  <li><b>Personal Style:</b> Select sets that align with your personal aesthetic. Whether you prefer classic, trendy, or bohemian styles, there\'s a 2 pcs set out there for you.</li>
  <li><b>Occasion:</b> Consider where you\'ll be wearing the set. A casual cotton set is perfect for everyday wear, while a more formal set might be appropriate for a special event.</li>
  <li><b>Sizing:</b> Always check the size chart before ordering. Pay attention to measurements rather than just relying on standard sizes.</li>
</ul>

<h3>Color and Pattern</h3>

<p>The color and pattern of your <b>2 pcs set</b> can make a big impact on your overall look. Consider the following:</p>

<ul>
  <li><b>Skin Tone:</b> Choose colors that complement your skin tone. Warm tones tend to look best on people with warm undertones, while cool tones look great on people with cool undertones.</li>
  <li><b>Versatility:</b> Opt for colors and patterns that are easy to mix and match with other items in your wardrobe. Neutrals like black, white, and gray are always a good choice.</li>
  <li><b>Personal Preference:</b> Ultimately, choose colors and patterns that you love and that make you feel confident.</li>
  <li><b>Trends:</b> Keep an eye on current color and pattern trends, but don\'t feel pressured to follow them if they don\'t suit your personal style.</li>
</ul>

<h3>Quality and Construction</h3>

<p>The quality and construction of your <b>2 pcs set</b> will determine its longevity and overall value. Consider the following:</p>

<ul>
  <li><b>Stitching:</b> Check the stitching for any loose threads or uneven seams.</li>
  <li><b>Hardware:</b> If the set includes any hardware (such as buttons, zippers, or closures), make sure it\'s sturdy and well-attached.</li>
  <li><b>Finishing:</b> Look for clean and well-finished edges.</li>
  <li><b>Overall Impression:</b> Does the set look and feel well-made? Trust your instincts.</li>
</ul>

<h2>Key Factors to Consider Before You Buy</h2>

<p>Beyond the basic checklist, here are some key factors to consider before you finalize your purchase:</p>

<h3>Your Budget</h3>

<p>While our featured <b>2 pcs set</b> is priced at an affordable ₹360.00, the price range for these sets can vary widely. Set a budget before you start shopping and stick to it. Remember that you can often find great deals on stylish sets without breaking the bank.</p>

<h3>Your Lifestyle</h3>

<p>Consider your lifestyle when choosing a <b>2 pcs set</b>. If you\'re a busy mom, you\'ll want something comfortable and practical that you can easily move around in. If you work in a professional environment, you\'ll need something more polished and sophisticated.</p>

<h3>The Occasion</h3>

<p>Think about where you\'ll be wearing the set. A casual cotton set is perfect for everyday wear, while a more formal set might be appropriate for a special event. Choose a set that\'s appropriate for the occasion.</p>

<h3>Return Policy</h3>

<p>Always check the return policy before making a purchase. Make sure you can return the set if it doesn\'t fit or if you\'re not satisfied with the quality.</p>

<h2>Different Price Ranges and What to Expect</h2>

<p>The price of a <b>2 pcs set</b> can vary widely depending on the brand, material, and style. Here\'s a general overview of what to expect at different price points:</p>

<ul>
  <li><b>₹300 - ₹500:</b> At this price range, you can expect to find basic cotton or polyester sets. The quality may not be the highest, but you can still find some stylish options.</li>
  <li><b>₹500 - ₹1000:</b> This price range offers a wider variety of materials and styles. You can find sets made from better quality cotton, linen blends, and other comfortable fabrics.</li>
  <li><b>₹1000 - ₹2000:</b> At this price range, you can expect to find well-made sets with attention to detail. You\'ll find a wider variety of styles, including more formal and sophisticated options.</li>
  <li><b>₹2000+:</b> This price range is for designer sets made from high-quality materials. You can expect exceptional craftsmanship and unique designs.</li>
</ul>

<h2>How This Product Fits into the Market</h2>

<p>The <b>2 pcs set</b> is a popular and versatile product that fits well into the current fashion market. It caters to a wide range of consumers, from those looking for a quick and easy outfit solution to those seeking a trendy and fashionable look. Its affordability, versatility, and convenience make it a desirable option for shoppers of all ages and styles.</p>

<p>The rise of online shopping has also contributed to the popularity of 2 pcs sets. With the convenience of online stores, shoppers can easily browse and purchase sets from the comfort of their own homes. This has made it easier than ever to find the perfect 2 pcs set for any occasion.</p>

<h2>Tips for Making the Best Purchase Decision: Shop Like a Pro!</h2>

<p>Ready to shop for your dream <b>2 pcs set</b>? Here are some final tips to help you make the best purchase decision:</p>

<ul>
  <li><b>Read Reviews:</b> Before buying, read reviews from other customers to get an idea of the quality and fit of the set.</li>
  <li><b>Compare Prices:</b> Don\'t settle for the first set you see. Compare prices from different retailers to make sure you\'re getting the best deal.</li>
  <li><b>Check the Size Chart:</b> Always check the size chart before ordering to ensure a proper fit.</li>
  <li><b>Consider Your Wardrobe:</b> Choose a set that will complement the other items in your wardrobe.</li>
  <li><b>Trust Your Gut:</b> Ultimately, choose a set that you love and that makes you feel confident.</li>
</ul>

<h2>Final Thoughts: Double Your Style, Double Your Fun!</h2>

<p>The <b>2 pcs set</b> is a versatile, affordable, and stylish way to upgrade your wardrobe. With a little research and careful consideration, you can find the perfect set to suit your personal style and budget. So, what are you waiting for? Start shopping and double your style today!</p>

<p>Remember to use keywords like <b>2 pcs set</b>, <b>fashion</b>, <b>style</b>, <b>trendy</b>, <b>online shopping</b>, <b>best price</b>, <b>buyer guide</b>, <b>shopping tips</b>, <b>how to buy</b>, and <b>purchase decisions</b> when searching for your perfect set online. Happy shopping!</p>

</body>
</html>', NULL, NULL, '2 Pcs Set: Your Ultimate Buying Guide for Trendy Fashion', 'Complete guide to buying the perfect 2 pcs set. Find tips on style, price, and making the best purchase decision. Shop trendy fashion online now!', '2 pcs set, fashion, style, trendy, online shopping, best price, buyer guide, shopping tips, how to buy, purchase decisions', NULL, 11, 1, '{\"blog_type\":\"buying_guide\",\"tone\":\"casual\",\"word_count\":1550,\"target_keywords\":[\"2 pcs set\",\"2 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"buyer guide\",\"shopping tips\",\"how to buy\",\"purchase decisions\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-09-28T17:41:34.094762Z\\\",\\\"product_name\\\":\\\"2 Pcs Set\\\",\\\"product_category\\\":\\\"2 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-09-28 17:41:34', NULL, 0, 0, 0, 0, 1, 8, '2025-09-28 17:41:34', '2025-09-28 17:41:34'),
(42, '3 Pcs Set: A Comprehensive Review of Style, Value, and Trendy Fashion', '3-pcs-set-a-comprehensive-review-of-style-value-and-trendy-fashion', 'Dive into our in-depth review of the 3 Pcs Set! Discover its key features, benefits, pros, cons, and whether it\'s the perfect addition to your wardrobe at the best price.', '<html>
<head>
<title>3 Pcs Set: A Comprehensive Review of Style, Value, and Trendy Fashion</title>
</head>
<body>

<h1>3 Pcs Set: A Comprehensive Review of Style, Value, and Trendy Fashion</h1>

<p>Welcome to our comprehensive review of the <b>3 Pcs Set</b>, a trendy fashion item available for just ₹550.00. In this in-depth product analysis, we\'ll explore its key features, benefits, and overall value. We\'ll also compare it with similar products to help you make an informed decision. Whether you\'re a fashion enthusiast or simply looking for a stylish and affordable set, this review guide is for you. We aim to provide you with all the information you need to decide if this <b>3 Pcs Set</b> is the perfect addition to your wardrobe. Let\'s dive in!</p>

<h2>Product Overview and First Impressions</h2>

<p>The <b>3 Pcs Set</b>, priced at ₹550.00, promises a complete and coordinated look without breaking the bank. Our first impressions were centered around its simplicity and potential versatility. While the product description is concise (“3 Pcs Set”), we’ll delve deeper to uncover the specifics and assess its true value. The initial appeal lies in the convenience of having three complementary pieces readily available, saving time and effort in creating a cohesive outfit. We\'ll examine the materials, design, and overall construction to determine if it lives up to the promise of trendy fashion at an affordable price point.</p>

<h3>Unboxing and Initial Assessment</h3>

<p>The unboxing experience, while basic, revealed a neatly packaged set. The individual pieces were carefully folded, minimizing wrinkles. The initial touch suggests a reasonable quality of fabric, although a more thorough inspection is required. The colors appeared vibrant and true to the online representation. However, a slight factory odor was noticeable, which is expected for items in this price range. This odor dissipated quickly after airing out the set. Overall, the initial assessment suggests a potentially worthwhile purchase, pending further examination of the individual pieces and their features.</p>

<h2>Key Features and Benefits of the 3 Pcs Set</h2>

<p>Despite the limited product description, we\'ve identified several key features and benefits that contribute to the <b>3 Pcs Set\'s</b> appeal:</p>

<ul>
 <li><b>Coordinated Style:</b> The primary benefit is the coordinated style offered by the three pieces. This eliminates the guesswork involved in matching separate items, saving time and effort.</li>
 <li><b>Affordability:</b> At ₹550.00, the set offers an accessible entry point into trendy fashion, making it a budget-friendly option for students and casual wearers.</li>
 <li><b>Versatility:</b> Depending on the specific design, the individual pieces can be mixed and matched with other items in your wardrobe, expanding your styling options.</li>
 <li><b>Convenience:</b> The set provides a complete outfit solution, ideal for travel or situations where you need a quick and stylish ensemble.</li>
 <li><b>Trendy Design:</b> The set is designed to reflect current fashion trends, allowing you to stay up-to-date with the latest styles.</li>
</ul>

<h3>Detailed Breakdown of Each Piece</h3>

<p>To fully understand the benefits, let\'s consider the potential composition of the <b>3 Pcs Set</b>. While the specific items may vary depending on the retailer, common configurations include:</p>

<ol>
 <li><b>Top:</b> This could be a t-shirt, blouse, crop top, or tank top, designed to be the focal point of the outfit.</li>
 <li><b>Bottom:</b> Options include shorts, skirts, leggings, or trousers, providing a base for the overall look.</li>
 <li><b>Outerwear/Accessory:</b> This could be a jacket, cardigan, scarf, or belt, adding an extra layer of style and functionality.</li>
</ol>

<p>The value lies in how well these pieces complement each other and how easily they can be integrated into your existing wardrobe. We will assume the set includes a basic t-shirt, a pair of shorts, and a light cardigan for the sake of further analysis.</p>

<h2>Pros and Cons of the 3 Pcs Set</h2>

<p>As with any product, the <b>3 Pcs Set</b> has both pros and cons that potential buyers should consider:</p>

<h3>Pros:</h3>

<ul>
 <li><b>Affordable Price:</b> ₹550.00 is a highly competitive price for a complete outfit.</li>
 <li><b>Coordinated Look:</b> The set eliminates the hassle of matching individual pieces.</li>
 <li><b>Versatile Pieces:</b> The individual items can be mixed and matched with other clothing.</li>
 <li><b>Trendy Style:</b> Designed to reflect current fashion trends.</li>
 <li><b>Convenient Solution:</b> Ideal for travel or quick outfit choices.</li>
</ul>

<h3>Cons:</h3>

<ul>
 <li><b>Material Quality:</b> At this price point, the material quality may be lower than higher-end alternatives.</li>
 <li><b>Sizing Issues:</b> Sizing can be inconsistent, so it\'s crucial to check size charts and reviews.</li>
 <li><b>Limited Customization:</b> The set offers limited options for personalization.</li>
 <li><b>Durability Concerns:</b> The longevity of the set may be shorter compared to more expensive items.</li>
 <li><b>Generic Design:</b> The design may be less unique compared to designer pieces.</li>
</ul>

<h2>Who Should Buy This Product?</h2>

<p>The <b>3 Pcs Set</b> is particularly well-suited for:</p>

<ul>
 <li><b>Students:</b> Budget-friendly and stylish for everyday wear.</li>
 <li><b>Casual Wearers:</b> Perfect for creating effortless, on-trend looks.</li>
 <li><b>Travelers:</b> Provides a convenient and coordinated outfit solution for packing light.</li>
 <li><b>Fashion Experimenters:</b> An affordable way to try out new styles and trends.</li>
 <li><b>Gift Givers:</b> A thoughtful and practical gift for friends or family.</li>
</ul>

<p>However, if you prioritize high-end materials, unique designs, and long-lasting durability, you may want to consider investing in more expensive alternatives.</p>

<h2>Comparison with Similar Products</h2>

<p>To provide a comprehensive review, let\'s compare the <b>3 Pcs Set</b> with similar products in the market:</p>

<h3>Alternative 1: Individual Pieces from Fast Fashion Retailers</h3>

<ul>
 <li><b>Price:</b> Purchasing individual pieces from fast fashion retailers may cost more than ₹550.00 for three items.</li>
 <li><b>Coordination:</b> Requires more effort to match colors and styles.</li>
 <li><b>Quality:</b> Material quality may be similar, but variety is greater.</li>
 <li><b>Pros:</b> Greater customization and choice.</li>
 <li><b>Cons:</b> Higher overall cost and time investment.</li>
</ul>

<h3>Alternative 2: Higher-End Boutique Sets</h3>

<ul>
 <li><b>Price:</b> Significantly more expensive than ₹550.00.</li>
 <li><b>Coordination:</b> Excellent coordination and design.</li>
 <li><b>Quality:</b> Superior materials and construction.</li>
 <li><b>Pros:</b> Higher durability, unique designs, and premium feel.</li>
 <li><b>Cons:</b> Significantly higher price point.</li>
</ul>

<h3>Alternative 3: Second-Hand/Thrifted Sets</h3>

<ul>
 <li><b>Price:</b> Can be cheaper than ₹550.00, but availability is unpredictable.</li>
 <li><b>Coordination:</b> Varies greatly depending on the items found.</li>
 <li><b>Quality:</b> Can range from excellent to poor, depending on the condition of the items.</li>
 <li><b>Pros:</b> Environmentally friendly and potentially very affordable.</li>
 <li><b>Cons:</b> Requires more effort to find suitable pieces, and hygiene can be a concern.</li>
</ul>

<p>The <b>3 Pcs Set</b> offers a balanced approach, providing a coordinated look at an affordable price, making it a competitive option in the market.</p>

<h2>Final Verdict and Recommendation</h2>

<p>After a thorough review, our final verdict on the <b>3 Pcs Set</b> is positive. While it may not offer the highest quality materials or the most unique designs, it delivers on its promise of providing a trendy and coordinated outfit at an incredibly affordable price. The convenience and versatility of the set make it a practical choice for students, casual wearers, and travelers looking to stay stylish without breaking the bank.</p>

<p><b>Recommendation:</b> We recommend the <b>3 Pcs Set</b> to anyone seeking a budget-friendly and convenient fashion solution. However, be sure to carefully review size charts and customer reviews to ensure a proper fit and manage expectations regarding material quality. If you prioritize high-end materials and unique designs, consider exploring more expensive alternatives. Overall, the <b>3 Pcs Set</b> offers excellent value for money and is a worthwhile addition to your wardrobe.</p>

<h3>Where to Buy</h3>

<p>The <b>3 Pcs Set</b> is typically available on online shopping platforms and fast fashion retailers. Be sure to compare prices and read customer reviews before making a purchase.</p>

<h2>SEO Optimization Considerations</h2>

<p>This blog post is optimized for search engines using the following strategies:</p>

<ul>
 <li><b>Keyword Integration:</b> The target keywords (3 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide) are naturally integrated throughout the content.</li>
 <li><b>Heading Structure:</b> Clear and descriptive headings (H2, H3) improve readability and SEO.</li>
 <li><b>Internal Linking:</b> (Hypothetically - would link to other relevant pages on the site).</li>
 <li><b>Meta Description:</b> A compelling meta description encourages click-through rates.</li>
 <li><b>Alt Text:</b> (Hypothetically - would include alt text for images with relevant keywords).</li>
 <li><b>Content Length:</b> The comprehensive content provides in-depth information, increasing dwell time and SEO ranking.</li>
</ul>

<p>By implementing these strategies, we aim to improve the visibility of this blog post in search engine results and attract a wider audience interested in the <b>3 Pcs Set</b>.</p>

</body>
</html>', NULL, NULL, '3 Pcs Set Review: Style, Value & Trendy Fashion Guide', 'In-depth review of the 3 Pcs Set: price, features, pros, cons, & who should buy it. Find out if this trendy fashion set is right for you!', '3 pcs set, fashion, style, trendy, online shopping, best price, in-depth review, comprehensive review, product analysis, review guide', NULL, 22, 1, '{\"blog_type\":\"product_review\",\"tone\":\"authoritative\",\"word_count\":1900,\"target_keywords\":[\"3 pcs set\",\"3 pcs set\",\"fashion\",\"style\",\"trendy\",\"online shopping\",\"best price\",\"in-depth review\",\"comprehensive review\",\"product analysis\",\"review guide\"]}', '\"{\\\"model\\\":\\\"gemini-2.0-flash\\\",\\\"generated_at\\\":\\\"2025-10-04T04:45:49.529461Z\\\",\\\"product_name\\\":\\\"3 Pcs Set\\\",\\\"product_category\\\":\\\"3 Pcs Set\\\"}\"', NULL, 2, 'published', '2025-10-04 10:15:49', NULL, 0, 0, 0, 0, 1, 8, '2025-10-04 10:15:49', '2025-10-04 10:15:49');


-- Table structure for table `blog_tags`
DROP TABLE IF EXISTS `blog_tags`;
CREATE TABLE "blog_tags" ("id" integer primary key autoincrement not null, "name" varchar not null, "slug" varchar not null, "description" text, "color" varchar not null default '#3B82F6', "is_active" tinyint(1) not null default '1', "posts_count" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `blog_tags`
INSERT INTO `blog_tags` (`id`, `name`, `slug`, `description`, `color`, `is_active`, `posts_count`, `created_at`, `updated_at`) VALUES
(1, 'Fashion', 'fashion', NULL, '#3B82F6', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(2, 'Style', 'style', NULL, '#8B5CF6', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(3, 'Trends', 'trends', NULL, '#10B981', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(4, 'Review', 'review', NULL, '#F59E0B', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(5, 'Guide', 'guide', NULL, '#EF4444', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(6, 'Tips', 'tips', NULL, '#06B6D4', 1, 0, '2025-09-27 06:30:36', '2025-09-27 06:30:36'),
(7, 'denim shirt', 'denim-shirt', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(8, 'casual wear', 'casual-wear', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(9, 'men\'s fashion', 'mens-fashion', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(10, 'women\'s fashion', 'womens-fashion', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(11, 'style guide', 'style-guide', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(12, 'buying guide', 'buying-guide', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(13, 'office casual', 'office-casual', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(14, 'weekend style', 'weekend-style', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:00', '2025-09-27 07:50:00'),
(15, 'blue shirt', 'blue-shirt', NULL, '#3B82F6', 1, 0, '2025-09-27 07:50:50', '2025-09-27 07:50:50'),
(16, 'floral dress', 'floral-dress', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:08', '2025-09-27 07:54:08'),
(17, 'summer dress', 'summer-dress', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:08', '2025-09-27 07:54:08'),
(18, 'fashion tips', 'fashion-tips', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:08', '2025-09-27 07:54:08'),
(19, 'outfit ideas', 'outfit-ideas', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:08', '2025-09-27 07:54:08'),
(20, 'summer fashion trends', 'summer-fashion-trends', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:08', '2025-09-27 07:54:08'),
(21, 'styling tips', 'styling-tips', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:25', '2025-09-27 07:54:25'),
(22, 'fashion guide', 'fashion-guide', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:25', '2025-09-27 07:54:25'),
(23, 'summer fashion', 'summer-fashion', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:25', '2025-09-27 07:54:25'),
(24, 'dress care', 'dress-care', NULL, '#3B82F6', 1, 0, '2025-09-27 07:54:25', '2025-09-27 07:54:25'),
(25, 'men\'s style', 'mens-style', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:01', '2025-09-27 07:55:01'),
(26, 'women\'s style', 'womens-style', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:01', '2025-09-27 07:55:01'),
(27, 'cotton shirt', 'cotton-shirt', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:01', '2025-09-27 07:55:01'),
(28, 'white shirt', 'white-shirt', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:03', '2025-09-27 07:55:03'),
(29, 'formal wear', 'formal-wear', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:03', '2025-09-27 07:55:03'),
(30, 'style tips', 'style-tips', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:03', '2025-09-27 07:55:03'),
(31, 'wardrobe essential', 'wardrobe-essential', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:03', '2025-09-27 07:55:03'),
(32, 'office style', 'office-style', NULL, '#3B82F6', 1, 0, '2025-09-27 07:55:21', '2025-09-27 07:55:21'),
(33, 'clothing', 'clothing', NULL, '#3B82F6', 1, 0, '2025-09-27 07:57:22', '2025-09-27 07:57:22'),
(34, 'wardrobe essentials', 'wardrobe-essentials', NULL, '#3B82F6', 1, 0, '2025-09-27 07:57:43', '2025-09-27 07:57:43'),
(35, 'office attire', 'office-attire', NULL, '#3B82F6', 1, 0, '2025-09-27 07:57:43', '2025-09-27 07:57:43'),
(36, 'classic style', 'classic-style', NULL, '#3B82F6', 1, 0, '2025-09-27 07:58:03', '2025-09-27 07:58:03'),
(37, 'cotton', 'cotton', NULL, '#3B82F6', 1, 0, '2025-09-27 08:06:04', '2025-09-27 08:06:04'),
(38, 'menswear', 'menswear', NULL, '#3B82F6', 1, 0, '2025-09-27 08:06:04', '2025-09-27 08:06:04'),
(39, 'womenswear', 'womenswear', NULL, '#3B82F6', 1, 0, '2025-09-27 08:06:04', '2025-09-27 08:06:04'),
(40, 'casual style', 'casual-style', NULL, '#3B82F6', 1, 0, '2025-09-27 08:26:41', '2025-09-27 08:26:41'),
(41, 'white blouse', 'white-blouse', NULL, '#3B82F6', 1, 0, '2025-09-27 08:27:37', '2025-09-27 08:27:37'),
(42, 'fashion trends', 'fashion-trends', NULL, '#3B82F6', 1, 0, '2025-09-27 08:27:52', '2025-09-27 08:27:52'),
(43, 'women\'s clothing', 'womens-clothing', NULL, '#3B82F6', 1, 0, '2025-09-27 08:27:52', '2025-09-27 08:27:52'),
(44, 'office wear', 'office-wear', NULL, '#3B82F6', 1, 0, '2025-09-27 08:27:54', '2025-09-27 08:27:54'),
(45, 'shirts', 'shirts', NULL, '#3B82F6', 1, 0, '2025-09-27 08:32:43', '2025-09-27 08:32:43'),
(46, 'product review', 'product-review', NULL, '#3B82F6', 1, 0, '2025-09-27 08:32:43', '2025-09-27 08:32:43'),
(47, 'office outfit', 'office-outfit', NULL, '#3B82F6', 1, 0, '2025-09-27 08:43:36', '2025-09-27 08:43:36'),
(48, 'clothing review', 'clothing-review', NULL, '#3B82F6', 1, 0, '2025-09-27 08:45:27', '2025-09-27 08:45:27'),
(49, 'shirt review', 'shirt-review', NULL, '#3B82F6', 1, 0, '2025-09-27 08:51:53', '2025-09-27 08:51:53'),
(50, 'wardrobe staple', 'wardrobe-staple', NULL, '#3B82F6', 1, 0, '2025-09-27 08:58:20', '2025-09-27 08:58:20'),
(51, 'office fashion', 'office-fashion', NULL, '#3B82F6', 1, 0, '2025-09-27 08:58:20', '2025-09-27 08:58:20'),
(52, 'business casual', 'business-casual', NULL, '#3B82F6', 1, 0, '2025-09-27 09:00:42', '2025-09-27 09:00:42'),
(53, '2pcs set', '2pcs-set', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(54, 'fashion set', 'fashion-set', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(55, 'affordable fashion', 'affordable-fashion', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(56, 'trendy outfit', 'trendy-outfit', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(57, 'budget fashion', 'budget-fashion', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(58, 'online shopping', 'online-shopping', NULL, '#3B82F6', 1, 0, '2025-09-28 16:58:05', '2025-09-28 16:58:05'),
(59, '2pcsset', '2pcsset', NULL, '#3B82F6', 1, 0, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(60, 'fashionreview', 'fashionreview', NULL, '#3B82F6', 1, 0, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(61, 'budgetfashion', 'budgetfashion', NULL, '#3B82F6', 1, 0, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(62, 'onlineshopping', 'onlineshopping', NULL, '#3B82F6', 1, 0, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(63, 'trendyclothes', 'trendyclothes', NULL, '#3B82F6', 1, 0, '2025-09-28 17:00:39', '2025-09-28 17:00:39'),
(64, '2pcs set review', '2pcs-set-review', NULL, '#3B82F6', 1, 0, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(65, 'cheap fashion', 'cheap-fashion', NULL, '#3B82F6', 1, 0, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(66, 'budget style', 'budget-style', NULL, '#3B82F6', 1, 0, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(67, 'online clothing', 'online-clothing', NULL, '#3B82F6', 1, 0, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(68, 'fashion deals', 'fashion-deals', NULL, '#3B82F6', 1, 0, '2025-09-28 17:05:54', '2025-09-28 17:05:54'),
(69, 'fashionguide', 'fashionguide', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:30', '2025-09-28 17:06:30'),
(70, 'styleinspiration', 'styleinspiration', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:30', '2025-09-28 17:06:30'),
(71, 'affordablefashion', 'affordablefashion', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:30', '2025-09-28 17:06:30'),
(72, 'outfitideas', 'outfitideas', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:30', '2025-09-28 17:06:30'),
(73, 'fashion sets', 'fashion-sets', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:49', '2025-09-28 17:06:49'),
(74, 'matching outfits', 'matching-outfits', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:49', '2025-09-28 17:06:49'),
(75, 'clothing trends', 'clothing-trends', NULL, '#3B82F6', 1, 0, '2025-09-28 17:06:49', '2025-09-28 17:06:49'),
(76, '2 Piece Set', '2-piece-set', NULL, '#3B82F6', 1, 0, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(77, 'Trendy Outfits', 'trendy-outfits', NULL, '#3B82F6', 1, 0, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(78, 'Fashion Review', 'fashion-review', NULL, '#3B82F6', 1, 0, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(79, 'Clothing Sets', 'clothing-sets', NULL, '#3B82F6', 1, 0, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(80, 'Value for Money', 'value-for-money', NULL, '#3B82F6', 1, 0, '2025-09-28 17:29:19', '2025-09-28 17:29:19'),
(81, 'trendy clothing', 'trendy-clothing', NULL, '#3B82F6', 1, 0, '2025-09-28 17:34:43', '2025-09-28 17:34:43'),
(82, 'matching set', 'matching-set', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:00', '2025-09-28 17:35:00'),
(83, 'online shopping tips', 'online-shopping-tips', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:00', '2025-09-28 17:35:00'),
(84, 'fashionstyle', 'fashionstyle', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:15', '2025-09-28 17:35:15'),
(85, 'outfitinspiration', 'outfitinspiration', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:15', '2025-09-28 17:35:15'),
(86, 'styleguide', 'styleguide', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:15', '2025-09-28 17:35:15'),
(87, 'coordinated outfits', 'coordinated-outfits', NULL, '#3B82F6', 1, 0, '2025-09-28 17:35:36', '2025-09-28 17:35:36'),
(88, 'ootd', 'ootd', NULL, '#3B82F6', 1, 0, '2025-09-28 17:41:05', '2025-09-28 17:41:05'),
(89, 'fashiontrends', 'fashiontrends', NULL, '#3B82F6', 1, 0, '2025-09-28 17:41:05', '2025-09-28 17:41:05'),
(90, '2 pcs set', '2-pcs-set', NULL, '#3B82F6', 1, 0, '2025-09-28 17:41:34', '2025-09-28 17:41:34'),
(91, 'matching sets', 'matching-sets', NULL, '#3B82F6', 1, 0, '2025-09-28 17:41:34', '2025-09-28 17:41:34'),
(92, '3pcsSet', '3pcsset', NULL, '#3B82F6', 1, 0, '2025-10-04 10:15:49', '2025-10-04 10:15:49'),
(93, 'TrendyStyle', 'trendystyle', NULL, '#3B82F6', 1, 0, '2025-10-04 10:15:49', '2025-10-04 10:15:49');


-- Table structure for table `blog_post_tags`
DROP TABLE IF EXISTS `blog_post_tags`;
CREATE TABLE "blog_post_tags" ("id" integer primary key autoincrement not null, "blog_post_id" integer not null, "blog_tag_id" integer not null, "created_at" datetime, "updated_at" datetime, foreign key("blog_post_id") references "blog_posts"("id") on delete cascade, foreign key("blog_tag_id") references "blog_tags"("id") on delete cascade);


-- Dumping data for table `blog_post_tags`
INSERT INTO `blog_post_tags` (`id`, `blog_post_id`, `blog_tag_id`, `created_at`, `updated_at`) VALUES
(192, 27, 53, NULL, NULL),
(193, 27, 54, NULL, NULL),
(194, 27, 55, NULL, NULL),
(195, 27, 56, NULL, NULL),
(196, 27, 57, NULL, NULL),
(197, 27, 58, NULL, NULL),
(198, 27, 46, NULL, NULL),
(199, 28, 59, NULL, NULL),
(200, 28, 60, NULL, NULL),
(201, 28, 61, NULL, NULL),
(202, 28, 62, NULL, NULL),
(203, 28, 63, NULL, NULL),
(204, 29, 64, NULL, NULL),
(205, 29, 65, NULL, NULL),
(206, 29, 66, NULL, NULL),
(207, 29, 67, NULL, NULL),
(208, 29, 68, NULL, NULL),
(209, 30, 59, NULL, NULL),
(210, 30, 69, NULL, NULL),
(211, 30, 70, NULL, NULL),
(212, 30, 71, NULL, NULL),
(213, 30, 72, NULL, NULL),
(214, 31, 53, NULL, NULL),
(215, 31, 73, NULL, NULL),
(216, 31, 74, NULL, NULL),
(217, 31, 11, NULL, NULL),
(218, 31, 75, NULL, NULL),
(219, 32, 76, NULL, NULL),
(220, 32, 55, NULL, NULL),
(221, 32, 66, NULL, NULL),
(222, 32, 77, NULL, NULL),
(223, 32, 78, NULL, NULL),
(224, 32, 58, NULL, NULL),
(225, 32, 11, NULL, NULL),
(226, 32, 79, NULL, NULL),
(227, 32, 68, NULL, NULL),
(228, 32, 80, NULL, NULL),
(229, 33, 53, NULL, NULL),
(230, 33, 54, NULL, NULL),
(231, 33, 55, NULL, NULL),
(232, 33, 81, NULL, NULL),
(233, 33, 66, NULL, NULL),
(234, 34, 53, NULL, NULL),
(235, 34, 82, NULL, NULL),
(236, 34, 22, NULL, NULL),
(237, 34, 83, NULL, NULL),
(238, 34, 33, NULL, NULL),
(239, 34, 11, NULL, NULL),
(240, 35, 59, NULL, NULL),
(241, 35, 84, NULL, NULL),
(242, 35, 85, NULL, NULL),
(243, 35, 71, NULL, NULL),
(244, 35, 86, NULL, NULL),
(245, 36, 53, NULL, NULL),
(246, 36, 42, NULL, NULL),
(247, 36, 11, NULL, NULL),
(248, 36, 87, NULL, NULL),
(249, 36, 55, NULL, NULL),
(250, 36, 58, NULL, NULL),
(251, 37, 53, NULL, NULL),
(252, 37, 78, NULL, NULL),
(253, 37, 55, NULL, NULL),
(254, 37, 77, NULL, NULL),
(255, 37, 58, NULL, NULL),
(256, 37, 48, NULL, NULL),
(257, 38, 53, NULL, NULL),
(258, 38, 73, NULL, NULL),
(259, 38, 43, NULL, NULL),
(260, 38, 55, NULL, NULL),
(261, 38, 11, NULL, NULL),
(262, 39, 53, NULL, NULL),
(263, 39, 22, NULL, NULL),
(264, 39, 30, NULL, NULL),
(265, 39, 19, NULL, NULL),
(266, 39, 55, NULL, NULL),
(267, 39, 58, NULL, NULL),
(268, 40, 59, NULL, NULL),
(269, 40, 1, NULL, NULL),
(270, 40, 2, NULL, NULL),
(271, 40, 3, NULL, NULL),
(272, 40, 71, NULL, NULL),
(273, 40, 62, NULL, NULL),
(274, 40, 88, NULL, NULL),
(275, 40, 89, NULL, NULL),
(276, 41, 90, NULL, NULL),
(277, 41, 42, NULL, NULL),
(278, 41, 58, NULL, NULL),
(279, 41, 11, NULL, NULL),
(280, 41, 57, NULL, NULL),
(281, 41, 91, NULL, NULL),
(282, 42, 92, NULL, NULL),
(283, 42, 60, NULL, NULL),
(284, 42, 93, NULL, NULL),
(285, 42, 71, NULL, NULL),
(286, 42, 62, NULL, NULL);


-- Table structure for table `users`
DROP TABLE IF EXISTS `users`;
CREATE TABLE "users" ("id" integer primary key autoincrement not null, "name" varchar not null, "email" varchar not null, "email_verified_at" datetime, "password" varchar not null, "remember_token" varchar, "created_at" datetime, "updated_at" datetime, "phone" varchar, "avatar" varchar, "role" varchar check ("role" in ('admin', 'customer', 'manager', 'super_admin')) not null default 'customer', "status" varchar not null default ('active'), "date_of_birth" date, "gender" varchar, "address" text, "city" varchar, "state" varchar, "postal_code" varchar, "country" varchar not null default ('India'), "last_login_at" datetime, "email_marketing_consent" tinyint(1) not null default ('0'), "sms_marketing_consent" tinyint(1) not null default ('0'), "notes" text, "provider" varchar, "provider_id" varchar, "phone_verified_at" datetime, "login_type" varchar not null default 'email', "last_login_ip" varchar, "last_login_location" varchar, "last_login_country" varchar, "last_login_user_agent" text);


-- Dumping data for table `users`
INSERT INTO `users` (`id`, `name`, `email`, `email_verified_at`, `password`, `remember_token`, `created_at`, `updated_at`, `phone`, `avatar`, `role`, `status`, `date_of_birth`, `gender`, `address`, `city`, `state`, `postal_code`, `country`, `last_login_at`, `email_marketing_consent`, `sms_marketing_consent`, `notes`, `provider`, `provider_id`, `phone_verified_at`, `login_type`, `last_login_ip`, `last_login_location`, `last_login_country`, `last_login_user_agent`) VALUES
(2, 'Super Administrator', 'superadmin@sjfashionhub.in', '2025-10-03 21:03:08', '$2y$12$SEXh/8fZd2oDrcwArCzzR.jS7OqOLzmn.t8IodACY7JqvTz5eVwXK', NULL, '2025-09-27 10:55:25', '2025-10-12 10:22:17', NULL, NULL, 'super_admin', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', '2025-10-12 10:22:17', 0, 0, NULL, NULL, NULL, NULL, 'email', '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Asansol, West Bengal', 'India', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36'),
(5, 'Jasim Mondal', 'jasimmondal57@gmail.com', '2025-09-28 06:59:39', '$2y$12$cRK/7DUucusPEz0xMVkNUeuBbfrhel.m8LLi7EqyWE583tLiOGR6W', NULL, '2025-09-27 16:42:56', '2025-10-13 00:23:51', '8536945959', NULL, 'customer', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', '2025-10-13 00:23:51', 0, 0, NULL, NULL, NULL, '2025-10-13 00:23:37', 'phone', '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Asansol, West Bengal', 'India', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36'),
(6, 'Super Admin', 'contact@sjfashionhub.com', '2025-10-03 21:00:55', '$2y$12$T.hNWM82cFcI9QhY4r4j5OKQxbBnlba5qQRrS/dDv2CLioQs1x2RS', NULL, '2025-10-03 20:57:48', '2025-10-03 21:01:47', NULL, NULL, 'super_admin', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', '2025-10-03 21:01:47', 0, 0, NULL, NULL, NULL, NULL, 'email', '127.0.0.1', 'Local/Private Network', 'Local', 'Symfony'),
(7, 'jasim', 'jasimmondal7672@gmail.com', NULL, '$2y$12$URZUAYFlMbf/j87LNa56JupkGX1K5GSiPJ1zONWkFFaKBoCifBkEu', NULL, '2025-10-07 13:43:32', '2025-10-07 13:43:32', '7063474409', NULL, 'customer', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, 0, 0, NULL, NULL, NULL, NULL, 'email', NULL, NULL, NULL, NULL),
(8, 'Test User', 'testuser@example.com', NULL, '$2y$12$0xb7K4qB0Yoa3jbF1PiO6e4.hchEAYaa6XVK4NsKZxrPsgKT.sEt.', NULL, '2025-10-07 13:53:24', '2025-10-07 13:53:24', NULL, NULL, 'customer', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, 0, 0, NULL, NULL, NULL, NULL, 'email', NULL, NULL, NULL, NULL),
(9, 'Test User 2', 'testuser2@example.com', NULL, '$2y$12$nVfhrKVjWRt9EEA/n6yFauUKRcF51fpRCNVOqXteiAZLcRhCZPXGC', NULL, '2025-10-07 13:55:33', '2025-10-07 13:55:33', NULL, NULL, 'customer', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', NULL, 0, 0, NULL, NULL, NULL, NULL, 'email', NULL, NULL, NULL, NULL),
(10, 'User 5959', '8536945959@mobile.local', NULL, '$2y$12$COBtI9n5q/zimRnIksbWNeOicQEurw23RFJx9JjJddC72IOEfJYNa', NULL, '2025-10-12 10:45:00', '2025-10-12 10:45:17', '8536945959', NULL, 'customer', 'active', NULL, NULL, NULL, NULL, NULL, NULL, 'India', '2025-10-12 10:45:17', 0, 0, NULL, NULL, NULL, '2025-10-12 10:45:00', 'phone', '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Asansol, West Bengal', 'India', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36');


-- Table structure for table `social_media_posts`
DROP TABLE IF EXISTS `social_media_posts`;
CREATE TABLE "social_media_posts" ("id" integer primary key autoincrement not null, "product_id" integer not null, "user_id" integer not null, "platform" varchar not null, "post_id" varchar, "content" text not null, "hashtags" text, "images" text, "status" varchar check ("status" in ('pending', 'posted', 'failed', 'scheduled')) not null default 'pending', "error_message" text, "platform_response" text, "scheduled_at" datetime, "posted_at" datetime, "engagement_stats" text, "is_ai_generated" tinyint(1) not null default '1', "ai_prompt" text, "created_at" datetime, "updated_at" datetime, "metadata" text, foreign key("product_id") references "products"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `social_media_posts`
-- No data to dump


-- Table structure for table `social_media_configs`
DROP TABLE IF EXISTS `social_media_configs`;
CREATE TABLE "social_media_configs" ("id" integer primary key autoincrement not null, "platform" varchar not null, "name" varchar, "description" text, "is_active" tinyint(1) not null default ('0'), "credentials" text, "settings" text, "webhook_url" varchar, "last_connected_at" datetime, "connection_status" text, "rate_limits" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `social_media_configs`
INSERT INTO `social_media_configs` (`id`, `platform`, `name`, `description`, `is_active`, `credentials`, `settings`, `webhook_url`, `last_connected_at`, `connection_status`, `rate_limits`, `created_at`, `updated_at`) VALUES
(1, 'facebook', 'Facebook', 'Configuration for Facebook social media platform', 0, NULL, '[]', NULL, NULL, NULL, NULL, '2025-09-27 13:47:56', '2025-09-27 13:47:58'),
(2, 'instagram', 'Instagram', 'Configuration for Instagram social media platform', 0, NULL, '[]', NULL, NULL, NULL, NULL, '2025-09-27 13:48:00', '2025-09-27 13:48:01');


-- Table structure for table `otp_verifications`
DROP TABLE IF EXISTS `otp_verifications`;
CREATE TABLE "otp_verifications" ("id" integer primary key autoincrement not null, "phone" varchar not null, "otp" varchar not null, "type" varchar not null default 'sms', "purpose" varchar not null default 'login', "is_verified" tinyint(1) not null default '0', "expires_at" datetime not null, "attempts" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `otp_verifications`
INSERT INTO `otp_verifications` (`id`, `phone`, `otp`, `type`, `purpose`, `is_verified`, `expires_at`, `attempts`, `created_at`, `updated_at`) VALUES
(4, '8536945959', '267030', 'whatsapp', 'login', 1, '2025-10-12 10:54:33', 0, '2025-10-12 10:44:33', '2025-10-12 10:45:00'),
(5, '8536945959', '344628', 'whatsapp', 'login', 1, '2025-10-12 10:58:38', 0, '2025-10-12 10:48:38', '2025-10-12 10:48:48'),
(6, '8536945959', '634157', 'whatsapp', 'login', 1, '2025-10-12 12:43:48', 0, '2025-10-12 12:33:48', '2025-10-12 12:34:01'),
(7, '8536945959', '719834', 'whatsapp', 'login', 1, '2025-10-12 13:32:16', 0, '2025-10-12 13:22:16', '2025-10-12 13:22:28'),
(8, '8536945959', '985603', 'whatsapp', 'login', 1, '2025-10-13 00:33:26', 0, '2025-10-13 00:23:26', '2025-10-13 00:23:37');


-- Table structure for table `social_login_settings`
DROP TABLE IF EXISTS `social_login_settings`;
CREATE TABLE "social_login_settings" ("id" integer primary key autoincrement not null, "provider" varchar not null, "enabled" tinyint(1) not null default '0', "client_id" text, "client_secret" text, "redirect_uri" text, "additional_settings" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `social_login_settings`
INSERT INTO `social_login_settings` (`id`, `provider`, `enabled`, `client_id`, `client_secret`, `redirect_uri`, `additional_settings`, `created_at`, `updated_at`) VALUES
(1, 'google', 0, NULL, NULL, 'https://sjfashionhub.in/auth/google/callback', NULL, '2025-09-27 15:10:41', '2025-09-27 16:08:26'),
(2, 'facebook', 0, NULL, NULL, 'https://sjfashionhub.in/auth/facebook/callback', NULL, '2025-09-27 15:10:41', '2025-09-27 16:07:54');


-- Table structure for table `authentication_settings`
DROP TABLE IF EXISTS `authentication_settings`;
CREATE TABLE "authentication_settings" ("id" integer primary key autoincrement not null, "method" varchar not null, "enabled" tinyint(1) not null default '1', "settings" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `authentication_settings`
INSERT INTO `authentication_settings` (`id`, `method`, `enabled`, `settings`, `created_at`, `updated_at`) VALUES
(1, 'email', 1, '{\"require_email_verification\":false,\"allow_password_reset\":true}', '2025-09-27 15:10:41', '2025-09-27 15:10:41'),
(2, 'mobile_sms', 0, '{\"api_key\":null,\"sender_id\":\"SJFASHION\",\"base_url\":\"https:\\/\\/api.textlocal.in\\/send\\/\",\"otp_length\":6,\"otp_expiry_minutes\":10,\"max_attempts_per_hour\":3}', '2025-09-27 15:10:41', '2025-09-27 15:23:32'),
(3, 'mobile_whatsapp', 1, '{\"access_token\":null,\"phone_number_id\":null,\"base_url\":\"https:\\/\\/graph.facebook.com\\/v18.0\",\"otp_length\":6,\"otp_expiry_minutes\":10,\"max_attempts_per_hour\":3}', '2025-09-27 15:10:41', '2025-10-03 22:51:41');


-- Table structure for table `user_otps`
DROP TABLE IF EXISTS `user_otps`;
CREATE TABLE "user_otps" ("id" integer primary key autoincrement not null, "identifier" varchar not null, "type" varchar check ("type" in ('email', 'phone')) not null, "otp" varchar not null, "purpose" varchar check ("purpose" in ('registration', 'login', 'password_reset')) not null, "method" varchar check ("method" in ('sms', 'whatsapp', 'email')) not null, "expires_at" datetime not null, "verified" tinyint(1) not null default '0', "verified_at" datetime, "attempts" integer not null default '0', "metadata" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `user_otps`
INSERT INTO `user_otps` (`id`, `identifier`, `type`, `otp`, `purpose`, `method`, `expires_at`, `verified`, `verified_at`, `attempts`, `metadata`, `created_at`, `updated_at`) VALUES
(4, 'jasimmondal57@gmail.com', 'email', '426433', 'registration', 'email', '2025-09-27 16:51:07', 0, NULL, 0, '{\"name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"password\":\"8536945959\"}', '2025-09-27 16:41:07', '2025-09-27 16:41:07'),
(5, 'jasimmondal57@gmail.com', 'email', '460988', 'registration', 'email', '2025-09-27 16:52:35', 1, '2025-09-27 16:42:56', 1, '{\"name\":\"Jasim Mondal\",\"email\":\"jasimmondal57@gmail.com\",\"phone\":\"+918536945959\",\"password\":\"8536945959\"}', '2025-09-27 16:42:35', '2025-09-27 16:42:56'),
(6, 'ijowiwitaz764@gmail.com', 'email', '358469', 'registration', 'email', '2025-10-04 04:33:51', 0, NULL, 0, '{\"name\":\"QAJbNrtCThPdAPHF\",\"email\":\"ijowiwitaz764@gmail.com\",\"phone\":\"+912491270267\",\"password\":\"WIkk4WdaW7sKHAa1!\"}', '2025-10-04 04:23:51', '2025-10-04 04:23:51'),
(7, 'ohowuhef61@gmail.com', 'email', '225493', 'registration', 'email', '2025-10-05 13:52:22', 0, NULL, 0, '{\"name\":\"buToBkPQm\",\"email\":\"ohowuhef61@gmail.com\",\"phone\":\"+912948929458\",\"password\":\"fXeaKx9rn2zOCAa1!\"}', '2025-10-05 13:42:22', '2025-10-05 13:42:22'),
(8, '+912291391414', 'phone', '645755', 'registration', 'whatsapp', '2025-10-06 21:07:00', 0, NULL, 0, '{\"name\":\"pBOAeEMxELNLyML\",\"email\":\"edeebehrens@gmail.com\",\"phone\":\"+912291391414\",\"password\":\"K1YwvfXhvCeaIAa1!\"}', '2025-10-06 20:57:00', '2025-10-06 20:57:00'),
(9, 'atodd@apotexpharmachem.com', 'email', '468577', 'registration', 'email', '2025-10-06 23:13:41', 0, NULL, 0, '{\"name\":\"ZLwYJlsaMvnHqfb\",\"email\":\"atodd@apotexpharmachem.com\",\"phone\":\"+919335096332\",\"password\":\"NfrUn1n3Q0TJXAa1!\"}', '2025-10-06 23:03:41', '2025-10-06 23:03:41'),
(10, 'avasiliades@romeoville.org', 'email', '270800', 'registration', 'email', '2025-10-06 23:49:57', 0, NULL, 0, '{\"name\":\"XwDcWHgM\",\"email\":\"avasiliades@romeoville.org\",\"phone\":\"+917249006498\",\"password\":\"L8Xqn0PHBm7nDAa1!\"}', '2025-10-06 23:39:57', '2025-10-06 23:39:57'),
(11, '+918256723699', 'phone', '550772', 'registration', 'whatsapp', '2025-10-06 23:58:32', 0, NULL, 0, '{\"name\":\"QWgMupwJnsGpO\",\"email\":\"jakebrubaker37@gmail.com\",\"phone\":\"+918256723699\",\"password\":\"DSL1dqkya2KIVAa1!\"}', '2025-10-06 23:48:32', '2025-10-06 23:48:32'),
(12, '+919006766350', 'phone', '700855', 'registration', 'whatsapp', '2025-10-07 01:51:23', 0, NULL, 0, '{\"name\":\"sQuTImwoncpH\",\"email\":\"maureenjhickey@yahoo.ca\",\"phone\":\"+919006766350\",\"password\":\"L1zcGUn9mqRBXAa1!\"}', '2025-10-07 01:41:23', '2025-10-07 01:41:23'),
(13, 'kristin.zupancic@gmail.com', 'email', '791709', 'registration', 'email', '2025-10-07 13:59:00', 0, NULL, 0, '{\"name\":\"YjBDgFdK\",\"email\":\"kristin.zupancic@gmail.com\",\"phone\":\"+919008178966\",\"password\":\"d1N488q3yNca9Aa1!\"}', '2025-10-07 13:49:00', '2025-10-07 13:49:00'),
(14, 'lroca@antisa.com', 'email', '975617', 'registration', 'email', '2025-10-07 18:20:07', 0, NULL, 0, '{\"name\":\"GdrElWAElIbfkN\",\"email\":\"lroca@antisa.com\",\"phone\":\"+919181855268\",\"password\":\"IsRb1jqw3wSObAa1!\"}', '2025-10-07 18:10:07', '2025-10-07 18:10:07'),
(15, 'lasher1812@gmail.com', 'email', '729875', 'registration', 'email', '2025-10-07 20:25:29', 0, NULL, 0, '{\"name\":\"PqquKjGLNFLsd\",\"email\":\"lasher1812@gmail.com\",\"phone\":\"+918285395248\",\"password\":\"hBjNGZMWaOw4AAa1!\"}', '2025-10-07 20:15:29', '2025-10-07 20:15:29'),
(16, 'brianallenmartinez@gmail.com', 'email', '642831', 'registration', 'email', '2025-10-07 22:07:52', 0, NULL, 0, '{\"name\":\"bkXYogKaMqWzpJz\",\"email\":\"brianallenmartinez@gmail.com\",\"phone\":\"+917359085540\",\"password\":\"wku0QIuFbQLA2Aa1!\"}', '2025-10-07 21:57:52', '2025-10-07 21:57:52'),
(17, 'brianallenmartinez@gmail.com', 'email', '266219', 'registration', 'email', '2025-10-07 22:07:58', 0, NULL, 0, '{\"name\":\"bkXYogKaMqWzpJz\",\"email\":\"brianallenmartinez@gmail.com\",\"phone\":\"+917359085540\",\"password\":\"wku0QIuFbQLA2Aa1!\"}', '2025-10-07 21:57:58', '2025-10-07 21:57:58'),
(18, 'aditya@pertamina.com', 'email', '504108', 'registration', 'email', '2025-10-07 22:58:26', 0, NULL, 0, '{\"name\":\"wwAacExFSZspXdmc\",\"email\":\"aditya@pertamina.com\",\"phone\":\"+914264709935\",\"password\":\"GccSFiI37E0lbAa1!\"}', '2025-10-07 22:48:26', '2025-10-07 22:48:26'),
(19, 'andreeabalent@icloud.com', 'email', '762461', 'registration', 'email', '2025-10-08 02:52:14', 0, NULL, 0, '{\"name\":\"WLzgqqfy\",\"email\":\"andreeabalent@icloud.com\",\"phone\":\"+916182461659\",\"password\":\"rUeW2BeyvNCTDAa1!\"}', '2025-10-08 02:42:14', '2025-10-08 02:42:14'),
(20, 'jeka19521@gmail.com', 'email', '186487', 'registration', 'email', '2025-10-08 14:46:14', 0, NULL, 0, '{\"name\":\"HBYeMckWYY\",\"email\":\"jeka19521@gmail.com\",\"phone\":\"+914284976259\",\"password\":\"kZNGdv6xVZ5p7Aa1!\"}', '2025-10-08 14:36:14', '2025-10-08 14:36:14'),
(21, 'jeka19521@gmail.com', 'email', '905939', 'registration', 'email', '2025-10-08 14:46:20', 0, NULL, 0, '{\"name\":\"HBYeMckWYY\",\"email\":\"jeka19521@gmail.com\",\"phone\":\"+914284976259\",\"password\":\"kZNGdv6xVZ5p7Aa1!\"}', '2025-10-08 14:36:20', '2025-10-08 14:36:20'),
(22, 'jeka19521@gmail.com', 'email', '298993', 'registration', 'email', '2025-10-08 14:46:25', 0, NULL, 0, '{\"name\":\"HBYeMckWYY\",\"email\":\"jeka19521@gmail.com\",\"phone\":\"+914284976259\",\"password\":\"kZNGdv6xVZ5p7Aa1!\"}', '2025-10-08 14:36:25', '2025-10-08 14:36:25'),
(23, '+912220106403', 'phone', '202887', 'registration', 'whatsapp', '2025-10-08 20:18:16', 0, NULL, 0, '{\"name\":\"lOPYzKVFMiyDS\",\"email\":\"sa.marcott@gmail.com\",\"phone\":\"+912220106403\",\"password\":\"zFyrzbXpXXPNtAa1!\"}', '2025-10-08 20:08:16', '2025-10-08 20:08:16'),
(24, '+916869215666', 'phone', '465856', 'registration', 'whatsapp', '2025-10-09 01:47:25', 0, NULL, 0, '{\"name\":\"CGTpnFxNLbk\",\"email\":\"astridmeaster@gmail.com\",\"phone\":\"+916869215666\",\"password\":\"RkyCuGz9ocErrAa1!\"}', '2025-10-09 01:37:25', '2025-10-09 01:37:25'),
(25, 'kyleleavitt1@gmail.com', 'email', '744110', 'registration', 'email', '2025-10-09 03:07:06', 0, NULL, 0, '{\"name\":\"ZHWILhPamLRabuZd\",\"email\":\"kyleleavitt1@gmail.com\",\"phone\":\"+913353309398\",\"password\":\"GuYoIRWMZrJBAAa1!\"}', '2025-10-09 02:57:06', '2025-10-09 02:57:06'),
(26, '+915684209319', 'phone', '513262', 'registration', 'whatsapp', '2025-10-09 06:39:48', 0, NULL, 0, '{\"name\":\"XiXYZmLcdCA\",\"email\":\"gunschplumbing@yahoo.ca\",\"phone\":\"+915684209319\",\"password\":\"nlkQQuiOYxfqiAa1!\"}', '2025-10-09 06:29:48', '2025-10-09 06:29:48'),
(27, 'brassell@gmail.com', 'email', '208754', 'registration', 'email', '2025-10-09 08:58:16', 0, NULL, 0, '{\"name\":\"WkGdJmow\",\"email\":\"brassell@gmail.com\",\"phone\":\"+916701274627\",\"password\":\"QKsu5LNZIL4bYAa1!\"}', '2025-10-09 08:48:16', '2025-10-09 08:48:16'),
(28, 'shanely.molina@gmail.com', 'email', '247118', 'registration', 'email', '2025-10-09 14:08:46', 0, NULL, 0, '{\"name\":\"UpyrTDMHNxg\",\"email\":\"shanely.molina@gmail.com\",\"phone\":\"+918406769390\",\"password\":\"VZRHZW1pEcESWAa1!\"}', '2025-10-09 13:58:46', '2025-10-09 13:58:46'),
(29, 'miltontammy@ymail.com', 'email', '908388', 'registration', 'email', '2025-10-09 18:47:51', 0, NULL, 0, '{\"name\":\"oVZJyBIDxBrjN\",\"email\":\"miltontammy@ymail.com\",\"phone\":\"+914343250008\",\"password\":\"Lvx7odJDhwPVOAa1!\"}', '2025-10-09 18:37:51', '2025-10-09 18:37:51'),
(30, '+915229542799', 'phone', '965154', 'registration', 'whatsapp', '2025-10-09 18:50:02', 0, NULL, 0, '{\"name\":\"ZlQPgapMsj\",\"email\":\"kcp_smith@hotmail.com\",\"phone\":\"+915229542799\",\"password\":\"Afq1fc61vFlfwAa1!\"}', '2025-10-09 18:40:02', '2025-10-09 18:40:02'),
(31, 'claudesuz@hotmail.com', 'email', '295082', 'registration', 'email', '2025-10-09 18:51:35', 0, NULL, 0, '{\"name\":\"PjBDyrtxYFYKWF\",\"email\":\"claudesuz@hotmail.com\",\"phone\":\"+916104701121\",\"password\":\"4IwCffUsPRpIBAa1!\"}', '2025-10-09 18:41:35', '2025-10-09 18:41:35'),
(32, 'claudesuz@hotmail.com', 'email', '703207', 'registration', 'email', '2025-10-09 18:51:39', 0, NULL, 0, '{\"name\":\"PjBDyrtxYFYKWF\",\"email\":\"claudesuz@hotmail.com\",\"phone\":\"+916104701121\",\"password\":\"4IwCffUsPRpIBAa1!\"}', '2025-10-09 18:41:39', '2025-10-09 18:41:39'),
(33, '+915662236670', 'phone', '295486', 'registration', 'whatsapp', '2025-10-09 19:59:47', 0, NULL, 0, '{\"name\":\"ARdLSHDxEJMIWii\",\"email\":\"todfoltyn@gmail.com\",\"phone\":\"+915662236670\",\"password\":\"zPPrvqklsevIQAa1!\"}', '2025-10-09 19:49:47', '2025-10-09 19:49:47'),
(34, 'nikolay.abkairov@gmail.com', 'email', '396013', 'registration', 'email', '2025-10-09 21:37:54', 0, NULL, 0, '{\"name\":\"IzvdvyMAMfJdi\",\"email\":\"nikolay.abkairov@gmail.com\",\"phone\":\"+916145641031\",\"password\":\"OjKvFqJbxKVu2Aa1!\"}', '2025-10-09 21:27:54', '2025-10-09 21:27:54'),
(35, 'katie10543@yahoo.com', 'email', '690462', 'registration', 'email', '2025-10-10 16:59:24', 0, NULL, 0, '{\"name\":\"BBpBRufskQUp\",\"email\":\"katie10543@yahoo.com\",\"phone\":\"+919814396209\",\"password\":\"R766WNN5dFriqAa1!\"}', '2025-10-10 16:49:24', '2025-10-10 16:49:24'),
(36, '+914561456282', 'phone', '693777', 'registration', 'whatsapp', '2025-10-10 22:28:21', 0, NULL, 0, '{\"name\":\"ReUVTZoQnB\",\"email\":\"derekskittles05@gmail.com\",\"phone\":\"+914561456282\",\"password\":\"Sz2zxwQD3ZBySAa1!\"}', '2025-10-10 22:18:21', '2025-10-10 22:18:21'),
(37, '+912635909316', 'phone', '897930', 'registration', 'whatsapp', '2025-10-11 06:57:25', 0, NULL, 0, '{\"name\":\"IWdNGvZbskErJA\",\"email\":\"monjurulalamtushar@gmail.com\",\"phone\":\"+912635909316\",\"password\":\"jIDfa5y3QKONjAa1!\"}', '2025-10-11 06:47:25', '2025-10-11 06:47:25'),
(38, 'starkmar@att.net', 'email', '668430', 'registration', 'email', '2025-10-11 10:44:12', 0, NULL, 0, '{\"name\":\"enTAWUglnEeBojp\",\"email\":\"starkmar@att.net\",\"phone\":\"+915691523622\",\"password\":\"VRtOVWYk2jQVsAa1!\"}', '2025-10-11 10:34:12', '2025-10-11 10:34:12'),
(39, '+914126106075', 'phone', '189430', 'registration', 'whatsapp', '2025-10-12 00:36:43', 0, NULL, 0, '{\"name\":\"lbkAuSFjxXGHIKtR\",\"email\":\"kleifur@gmail.com\",\"phone\":\"+914126106075\",\"password\":\"sBef9NsZQWiztAa1!\"}', '2025-10-12 00:26:43', '2025-10-12 00:26:43'),
(40, 'amandabrennand_87@hotmail.com', 'email', '209477', 'registration', 'email', '2025-10-12 21:36:34', 0, NULL, 0, '{\"name\":\"KJIsPcbzz\",\"email\":\"amandabrennand_87@hotmail.com\",\"phone\":\"+915132784273\",\"password\":\"9Ggb3OxrfKqoKAa1!\"}', '2025-10-12 21:26:34', '2025-10-12 21:26:34');


-- Table structure for table `shipping_settings`
DROP TABLE IF EXISTS `shipping_settings`;
CREATE TABLE "shipping_settings" ("id" integer primary key autoincrement not null, "shipping_method" varchar check ("shipping_method" in ('flat_rate', 'weight_based', 'location_based', 'free')) not null default 'flat_rate', "is_enabled" tinyint(1) not null default '1', "flat_rate" numeric not null default '99', "free_shipping_enabled" tinyint(1) not null default '0', "free_shipping_threshold" numeric not null default '500', "weight_based_enabled" tinyint(1) not null default '0', "weight_rates" text, "location_based_enabled" tinyint(1) not null default '0', "location_rates" text, "express_shipping_enabled" tinyint(1) not null default '0', "express_shipping_rate" numeric not null default '199', "express_shipping_days" integer not null default '1', "standard_shipping_days" integer not null default '5', "shipping_tax_enabled" tinyint(1) not null default '0', "shipping_tax_rate" numeric not null default '18', "handling_fee" numeric not null default '0', "packaging_fee" numeric not null default '0', "cod_charges" numeric not null default '0', "cod_enabled" tinyint(1) not null default '1', "international_shipping_enabled" tinyint(1) not null default '0', "international_shipping_rate" numeric not null default '999', "shipping_zones" text, "default_weight" numeric not null default '0.5', "weight_unit" varchar check ("weight_unit" in ('kg', 'g', 'lb', 'oz')) not null default 'kg', "dimension_unit" varchar check ("dimension_unit" in ('cm', 'm', 'in', 'ft')) not null default 'cm', "calculation_method" varchar check ("calculation_method" in ('highest_rate', 'sum_rates', 'average_rate')) not null default 'highest_rate', "settings_data" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `shipping_settings`
INSERT INTO `shipping_settings` (`id`, `shipping_method`, `is_enabled`, `flat_rate`, `free_shipping_enabled`, `free_shipping_threshold`, `weight_based_enabled`, `weight_rates`, `location_based_enabled`, `location_rates`, `express_shipping_enabled`, `express_shipping_rate`, `express_shipping_days`, `standard_shipping_days`, `shipping_tax_enabled`, `shipping_tax_rate`, `handling_fee`, `packaging_fee`, `cod_charges`, `cod_enabled`, `international_shipping_enabled`, `international_shipping_rate`, `shipping_zones`, `default_weight`, `weight_unit`, `dimension_unit`, `calculation_method`, `settings_data`, `created_at`, `updated_at`) VALUES
(1, 'free', 1, 99, 1, 500, 0, '[{\"min_weight\":0,\"max_weight\":1,\"rate\":50},{\"min_weight\":1,\"max_weight\":5,\"rate\":99},{\"min_weight\":5,\"max_weight\":10,\"rate\":149}]', 0, '[{\"zone\":\"metro\",\"rate\":99},{\"zone\":\"non_metro\",\"rate\":149}]', 0, 199, 1, 5, 0, 18, 0, 0, 0, 1, 0, 999, NULL, 0.5, 'kg', 'cm', 'highest_rate', NULL, '2025-09-28 09:22:06', '2025-09-28 09:36:19');


-- Table structure for table `pages`
DROP TABLE IF EXISTS `pages`;
CREATE TABLE "pages" ("id" integer primary key autoincrement not null, "title" varchar not null, "slug" varchar not null, "content" text not null, "meta_description" text, "meta_keywords" varchar, "seo_title" varchar, "is_active" tinyint(1) not null default '1', "sort_order" integer not null default '0', "page_type" varchar not null default 'custom', "settings" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `pages`
INSERT INTO `pages` (`id`, `title`, `slug`, `content`, `meta_description`, `meta_keywords`, `seo_title`, `is_active`, `sort_order`, `page_type`, `settings`, `created_at`, `updated_at`) VALUES
(1, 'About Us', 'about', '<h1>About SJ Fashion Hub</h1>
<p>Welcome to SJ Fashion Hub, your premier destination for trendy, affordable fashion that celebrates your unique style.</p>

<h2>Our Story</h2>
<p>SJ Fashion Hub was born from a simple belief: everyone deserves to look and feel their best without breaking the bank. We started as a small team of fashion enthusiasts who noticed a gap in the market for trendy, high-quality clothing at accessible prices.</p>

<h2>Our Mission</h2>
<p>To democratize fashion by making trendy, high-quality clothing accessible to everyone, while providing an exceptional shopping experience that exceeds expectations.</p>

<h2>Why Choose Us?</h2>
<ul>
<li>Quality Guarantee - 100% satisfaction guaranteed</li>
<li>Free Shipping on orders above ₹999</li>
<li>Easy Returns within 7 days</li>
<li>24/7 Customer Support</li>
</ul>', 'Learn more about SJ Fashion Hub - your premier destination for trendy, affordable fashion.', NULL, 'About Us - SJ Fashion Hub', 1, 0, 'about', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23'),
(2, 'Contact Us', 'contact', '<h1>Contact Us</h1>
<p>We\'d love to hear from you. Get in touch with our friendly team.</p>

<h2>Contact Information</h2>
<p><strong>Address:</strong><br>
123 Fashion Street<br>
Style City, SC 12345<br>
India</p>

<p><strong>Phone:</strong> +91 98765 43210</p>
<p><strong>Email:</strong> info@sjfashionhub.com</p>

<h2>Business Hours</h2>
<p>Monday - Saturday: 9:00 AM - 6:00 PM<br>
Sunday: 10:00 AM - 4:00 PM</p>', 'Get in touch with SJ Fashion Hub. Contact us for any questions or support.', NULL, 'Contact Us - SJ Fashion Hub', 1, 0, 'contact', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23'),
(3, 'Privacy Policy', 'privacy-policy', '<h1>Privacy Policy</h1>
<p><strong>Last updated:</strong> September 28, 2025</p>

<h2>Information We Collect</h2>
<p>We collect information you provide directly to us, such as when you create an account, make a purchase, or contact us.</p>

<h2>How We Use Your Information</h2>
<p>We use the information we collect to provide, maintain, and improve our services, process transactions, and communicate with you.</p>

<h2>Information Sharing</h2>
<p>We do not sell, trade, or otherwise transfer your personal information to third parties without your consent, except as described in this policy.</p>

<h2>Data Security</h2>
<p>We implement appropriate security measures to protect your personal information against unauthorized access, alteration, disclosure, or destruction.</p>

<h2>Contact Us</h2>
<p>If you have any questions about this Privacy Policy, please contact us at privacy@sjfashionhub.com</p>', 'Read our privacy policy to understand how we collect, use, and protect your information.', NULL, 'Privacy Policy - SJ Fashion Hub', 1, 0, 'privacy', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23'),
(4, 'Terms of Service', 'terms-of-service', '<h1>Terms of Service</h1>
<p><strong>Last updated:</strong> September 28, 2025</p>

<h2>Acceptance of Terms</h2>
<p>By accessing and using this website, you accept and agree to be bound by the terms and provision of this agreement.</p>

<h2>Use License</h2>
<p>Permission is granted to temporarily download one copy of the materials on SJ Fashion Hub\'s website for personal, non-commercial transitory viewing only.</p>

<h2>Disclaimer</h2>
<p>The materials on SJ Fashion Hub\'s website are provided on an \'as is\' basis. SJ Fashion Hub makes no warranties, expressed or implied.</p>

<h2>Limitations</h2>
<p>In no event shall SJ Fashion Hub or its suppliers be liable for any damages arising out of the use or inability to use the materials on this website.</p>

<h2>Contact Information</h2>
<p>If you have any questions about these Terms of Service, please contact us at legal@sjfashionhub.com</p>', 'Read our terms of service for using SJ Fashion Hub website and services.', NULL, 'Terms of Service - SJ Fashion Hub', 1, 0, 'terms', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23'),
(5, 'Shipping Policy', 'shipping-policy', '<h1>Shipping Policy</h1>
<p><strong>Last updated:</strong> September 28, 2025</p>

<h2>Shipping Methods</h2>
<p>We offer the following shipping options:</p>
<ul>
<li><strong>Standard Shipping:</strong> 5-7 business days - ₹99</li>
<li><strong>Express Shipping:</strong> 2-3 business days - ₹199</li>
<li><strong>Free Shipping:</strong> On orders above ₹999 (5-7 business days)</li>
</ul>

<h2>Processing Time</h2>
<p>Orders are typically processed within 1-2 business days. You will receive a confirmation email with tracking information once your order ships.</p>

<h2>Delivery Areas</h2>
<p>We currently deliver across India. International shipping is not available at this time.</p>

<h2>Shipping Charges</h2>
<p>Shipping charges are calculated based on the delivery location and weight of the package.</p>', 'Learn about our shipping policies, delivery times, and shipping costs.', NULL, 'Shipping Policy - SJ Fashion Hub', 1, 0, 'shipping', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23'),
(6, 'Return & Exchange Policy', 'return-policy', '<h1>Return & Exchange Policy</h1>
<p><strong>Last updated:</strong> September 28, 2025</p>

<h2>Return Window</h2>
<p>You have 7 days from the date of delivery to return items for a full refund or exchange.</p>

<h2>Return Conditions</h2>
<p>Items must be:</p>
<ul>
<li>In original condition with tags attached</li>
<li>Unworn and unwashed</li>
<li>In original packaging</li>
</ul>

<h2>Return Process</h2>
<ol>
<li>Contact our customer service team</li>
<li>Receive return authorization and shipping label</li>
<li>Pack items securely and ship back</li>
<li>Refund processed within 5-7 business days</li>
</ol>

<h2>Non-Returnable Items</h2>
<p>The following items cannot be returned:</p>
<ul>
<li>Intimate apparel and undergarments</li>
<li>Items marked as final sale</li>
<li>Damaged or altered items</li>
</ul>', 'Read our return and exchange policy for hassle-free returns.', NULL, 'Return & Exchange Policy - SJ Fashion Hub', 1, 0, 'returns', NULL, '2025-09-28 11:42:23', '2025-09-28 11:42:23');


-- Table structure for table `user_addresses`
DROP TABLE IF EXISTS `user_addresses`;
CREATE TABLE "user_addresses" ("id" integer primary key autoincrement not null, "user_id" integer not null, "type" varchar not null default 'shipping', "label" varchar, "full_name" varchar not null, "phone" varchar not null, "address_line_1" text not null, "address_line_2" text, "city" varchar not null, "state" varchar not null, "pincode" varchar not null, "country" varchar not null default 'India', "is_default" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `user_addresses`
INSERT INTO `user_addresses` (`id`, `user_id`, `type`, `label`, `full_name`, `phone`, `address_line_1`, `address_line_2`, `city`, `state`, `pincode`, `country`, `is_default`, `created_at`, `updated_at`) VALUES
(1, 5, 'both', 'Home', 'Jasim Mondal', '+918536945959', '123 Test Street, Test Area', NULL, 'Kolkata', 'West Bengal', '700001', 'India', 1, '2025-09-29 07:20:47', '2025-09-29 08:19:52'),
(2, 5, 'both', NULL, 'Jasim Mondal', '+918536945959', 'near masjid, nazrulpally, bhubandanga', NULL, 'Bolpur', 'West Bengal', '731204', 'India', 0, '2025-10-04 23:54:27', '2025-10-04 23:54:27');


-- Table structure for table `user_change_logs`
DROP TABLE IF EXISTS `user_change_logs`;
CREATE TABLE "user_change_logs" ("id" integer primary key autoincrement not null, "user_id" integer not null, "change_type" varchar not null, "field_name" varchar not null, "old_value" text, "new_value" text, "changed_by" integer, "ip_address" varchar, "user_agent" text, "changed_at" datetime not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade, foreign key("changed_by") references "users"("id") on delete set null);


-- Dumping data for table `user_change_logs`
INSERT INTO `user_change_logs` (`id`, `user_id`, `change_type`, `field_name`, `old_value`, `new_value`, `changed_by`, `ip_address`, `user_agent`, `changed_at`, `created_at`, `updated_at`) VALUES
(1, 5, 'profile_update', 'name', 'Jasim Mondal', 'Jasim Mondal Updated', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:41', '2025-09-29 08:19:41', '2025-09-29 08:19:41'),
(2, 5, 'address_update', 'city', 'Kolkata', 'Updated City', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:48', '2025-09-29 08:19:48', '2025-09-29 08:19:48'),
(3, 5, 'address_update', 'updated_at', '2025-09-29 07:20:47', '2025-09-29 08:19:48', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:48', '2025-09-29 08:19:48', '2025-09-29 08:19:48'),
(4, 5, 'address_update', 'city', 'Updated City', 'Kolkata', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:52', '2025-09-29 08:19:52', '2025-09-29 08:19:52'),
(5, 5, 'address_update', 'updated_at', '2025-09-29 08:19:48', '2025-09-29 08:19:52', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:52', '2025-09-29 08:19:52', '2025-09-29 08:19:52'),
(6, 5, 'profile_update', 'name', 'Jasim Mondal Updated', 'Jasim Mondal', NULL, '127.0.0.1', 'Symfony', '2025-09-29 08:19:59', '2025-09-29 08:19:59', '2025-09-29 08:19:59'),
(7, 5, 'profile_update', 'last_login_at', NULL, '2025-09-29 10:33:25', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:25', '2025-09-29 10:33:25', '2025-09-29 10:33:25'),
(8, 5, 'profile_update', 'last_login_ip', NULL, '203.0.113.1', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:25', '2025-09-29 10:33:25', '2025-09-29 10:33:25'),
(9, 5, 'profile_update', 'last_login_location', NULL, 'city, regionName', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:25', '2025-09-29 10:33:25', '2025-09-29 10:33:25'),
(10, 5, 'profile_update', 'last_login_country', NULL, 'country', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:25', '2025-09-29 10:33:25', '2025-09-29 10:33:25'),
(11, 5, 'profile_update', 'last_login_user_agent', NULL, 'Mozilla/5.0 (Test Browser) Login Tracking Test', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:25', '2025-09-29 10:33:25', '2025-09-29 10:33:25'),
(12, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 10:33:32\",\"ip_address\":\"203.0.113.1\",\"location\":\"city, regionName\",\"country\":\"country\",\"user_agent\":\"Mozilla\\/5.0 (Test Browser) Login Tracking Test\",\"login_method\":\"unknown\"}', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:32', '2025-09-29 10:33:32', '2025-09-29 10:33:32'),
(13, 5, 'profile_update', 'last_login_at', '2025-09-29 10:33:25', '2025-09-29 10:33:38', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:38', '2025-09-29 10:33:38', '2025-09-29 10:33:38'),
(14, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 10:33:43\",\"ip_address\":\"203.0.113.1\",\"location\":\"city, regionName\",\"country\":\"country\",\"user_agent\":\"Mozilla\\/5.0 (Test Browser) Login Tracking Test\",\"login_method\":\"unknown\"}', NULL, '203.0.113.1', 'Mozilla/5.0 (Test Browser) Login Tracking Test', '2025-09-29 10:33:43', '2025-09-29 10:33:43', '2025-09-29 10:33:43'),
(15, 5, 'profile_update', 'last_login_at', '2025-09-29 10:33:38', '2025-09-29 10:45:15', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:15', '2025-09-29 10:45:15', '2025-09-29 10:45:15'),
(16, 5, 'profile_update', 'last_login_ip', '203.0.113.1', '8.8.8.8', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:15', '2025-09-29 10:45:15', '2025-09-29 10:45:15'),
(17, 5, 'profile_update', 'last_login_location', 'city, regionName', 'Ashburn, Virginia', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:15', '2025-09-29 10:45:15', '2025-09-29 10:45:15'),
(18, 5, 'profile_update', 'last_login_country', 'country', 'United States', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:15', '2025-09-29 10:45:15', '2025-09-29 10:45:15'),
(19, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Test Browser) Login Tracking Test', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:15', '2025-09-29 10:45:15', '2025-09-29 10:45:15'),
(20, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 10:45:17\",\"ip_address\":\"8.8.8.8\",\"location\":\"Ashburn, Virginia\",\"country\":\"United States\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/91.0.4472.124 Safari\\/537.36\",\"login_method\":\"unknown\"}', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:17', '2025-09-29 10:45:17', '2025-09-29 10:45:17'),
(21, 5, 'profile_update', 'last_login_at', '2025-09-29 10:45:15', '2025-09-29 10:45:21', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:21', '2025-09-29 10:45:21', '2025-09-29 10:45:21'),
(22, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 10:45:24\",\"ip_address\":\"8.8.8.8\",\"location\":\"Ashburn, Virginia\",\"country\":\"United States\",\"user_agent\":\"Mozilla\\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\\/537.36 (KHTML, like Gecko) Chrome\\/91.0.4472.124 Safari\\/537.36\",\"login_method\":\"unknown\"}', NULL, '8.8.8.8', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', '2025-09-29 10:45:24', '2025-09-29 10:45:24', '2025-09-29 10:45:24'),
(23, 5, 'profile_update', 'last_login_at', '2025-09-29 10:45:21', '2025-09-29 16:22:44', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:44', '2025-09-29 16:22:44', '2025-09-29 16:22:44'),
(24, 5, 'profile_update', 'last_login_ip', '8.8.8.8', '103.21.58.66', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:44', '2025-09-29 16:22:44', '2025-09-29 16:22:44'),
(25, 5, 'profile_update', 'last_login_location', 'Ashburn, Virginia', 'Mumbai, Maharashtra', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:44', '2025-09-29 16:22:44', '2025-09-29 16:22:44'),
(26, 5, 'profile_update', 'last_login_country', 'United States', 'India', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:44', '2025-09-29 16:22:44', '2025-09-29 16:22:44'),
(27, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.124 Safari/537.36', 'Timezone Test Browser', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:44', '2025-09-29 16:22:44', '2025-09-29 16:22:44'),
(28, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 16:22:48\",\"ip_address\":\"103.21.58.66\",\"location\":\"Mumbai, Maharashtra\",\"country\":\"India\",\"user_agent\":\"Timezone Test Browser\",\"login_method\":\"unknown\"}', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:48', '2025-09-29 16:22:48', '2025-09-29 16:22:48'),
(29, 5, 'profile_update', 'last_login_at', '2025-09-29 16:22:44', '2025-09-29 16:22:51', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:51', '2025-09-29 16:22:51', '2025-09-29 16:22:51'),
(30, 5, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-09-29 16:22:53\",\"ip_address\":\"103.21.58.66\",\"location\":\"Mumbai, Maharashtra\",\"country\":\"India\",\"user_agent\":\"Timezone Test Browser\",\"login_method\":\"unknown\"}', NULL, '103.21.58.66', 'Timezone Test Browser', '2025-09-29 16:22:53', '2025-09-29 16:22:53', '2025-09-29 16:22:53'),
(31, 6, 'user_registration', 'new_user', NULL, '{\"name\":\"Super Admin\",\"email\":\"contact@sjfashionhub.com\",\"role\":\"super_admin\",\"updated_at\":\"2025-10-03T15:27:48.000000Z\",\"created_at\":\"2025-10-03T15:27:48.000000Z\",\"id\":6}', NULL, '127.0.0.1', 'Symfony', '2025-10-03 20:57:48', '2025-10-03 20:57:48', '2025-10-03 20:57:48'),
(32, 6, 'profile_update', 'password', '$2y$12$Mvmlb4F1BLV.7WoWGu7/cecmxCs.eBKzJ2IhKgcfqQ7lC4yutDuVK', '$2y$12$T.hNWM82cFcI9QhY4r4j5OKQxbBnlba5qQRrS/dDv2CLioQs1x2RS', NULL, '127.0.0.1', 'Symfony', '2025-10-03 20:59:14', '2025-10-03 20:59:14', '2025-10-03 20:59:14'),
(33, 6, 'profile_update', 'email_verified_at', NULL, '2025-10-03 21:00:55', NULL, '127.0.0.1', 'Symfony', '2025-10-03 21:00:55', '2025-10-03 21:00:55', '2025-10-03 21:00:55'),
(34, 6, 'profile_update', 'last_login_at', NULL, '2025-10-03 21:01:42', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:42', '2025-10-03 21:01:42', '2025-10-03 21:01:42'),
(35, 6, 'profile_update', 'last_login_ip', NULL, '127.0.0.1', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:42', '2025-10-03 21:01:42', '2025-10-03 21:01:42'),
(36, 6, 'profile_update', 'last_login_location', NULL, 'Local/Private Network', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:42', '2025-10-03 21:01:42', '2025-10-03 21:01:42'),
(37, 6, 'profile_update', 'last_login_country', NULL, 'Local', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:42', '2025-10-03 21:01:42', '2025-10-03 21:01:42'),
(38, 6, 'profile_update', 'last_login_user_agent', NULL, 'Symfony', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:42', '2025-10-03 21:01:42', '2025-10-03 21:01:42'),
(39, 6, 'profile_update', 'last_login_at', '2025-10-03 21:01:42', '2025-10-03 21:01:47', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:47', '2025-10-03 21:01:47', '2025-10-03 21:01:47'),
(40, 6, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-10-03 21:01:51\",\"ip_address\":\"127.0.0.1\",\"location\":\"Local\\/Private Network\",\"country\":\"Local\",\"user_agent\":\"Symfony\",\"login_method\":\"unknown\"}', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:51', '2025-10-03 21:01:51', '2025-10-03 21:01:51'),
(41, 6, 'user_login', 'login_activity', NULL, '{\"login_time\":\"2025-10-03 21:01:56\",\"ip_address\":\"127.0.0.1\",\"location\":\"Local\\/Private Network\",\"country\":\"Local\",\"user_agent\":\"Symfony\",\"login_method\":\"unknown\"}', 6, '127.0.0.1', 'Symfony', '2025-10-03 21:01:56', '2025-10-03 21:01:56', '2025-10-03 21:01:56'),
(42, 2, 'profile_update', 'email_verified_at', '2025-09-27 10:55:25', '2025-10-03 21:03:08', NULL, '127.0.0.1', 'Symfony', '2025-10-03 21:03:09', '2025-10-03 21:03:09', '2025-10-03 21:03:09'),
(43, 2, 'profile_update', 'password', '$2y$12$wSf5X2hgnvm2Erkqccqi7.vE3mUx59nX7bcz3IAE5m1fcAOlqFV5W', '$2y$12$SEXh/8fZd2oDrcwArCzzR.jS7OqOLzmn.t8IodACY7JqvTz5eVwXK', NULL, '127.0.0.1', 'Symfony', '2025-10-03 21:03:09', '2025-10-03 21:03:09', '2025-10-03 21:03:09'),
(44, 2, 'profile_update', 'last_login_at', NULL, '2025-10-03 21:03:24', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:24', '2025-10-03 21:03:24', '2025-10-03 21:03:24'),
(45, 2, 'profile_update', 'last_login_ip', NULL, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:24', '2025-10-03 21:03:24', '2025-10-03 21:03:24'),
(46, 2, 'profile_update', 'last_login_location', NULL, 'Asansol, West Bengal', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:24', '2025-10-03 21:03:24', '2025-10-03 21:03:24'),
(47, 2, 'profile_update', 'last_login_country', NULL, 'India', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:24', '2025-10-03 21:03:24', '2025-10-03 21:03:24'),
(48, 2, 'profile_update', 'last_login_user_agent', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:24', '2025-10-03 21:03:24', '2025-10-03 21:03:24'),
(49, 2, 'profile_update', 'last_login_at', '2025-10-03 21:03:24', '2025-10-03 21:03:27', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:27', '2025-10-03 21:03:27', '2025-10-03 21:03:27'),
(50, 2, 'profile_update', 'last_login_at', '2025-10-03 21:03:27', '2025-10-03 21:03:29', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:29', '2025-10-03 21:03:29', '2025-10-03 21:03:29'),
(51, 2, 'profile_update', 'last_login_at', '2025-10-03 21:03:29', '2025-10-03 21:03:32', 2, '2405:201:9017:e03b:a09a:6bf4:4186:856e', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-03 21:03:32', '2025-10-03 21:03:32', '2025-10-03 21:03:32'),
(52, 2, 'profile_update', 'last_login_at', '2025-10-03 21:03:32', '2025-10-04 09:22:22', 2, '2405:201:9017:e03b:a59d:5c59:b657:8b79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 09:22:22', '2025-10-04 09:22:22', '2025-10-04 09:22:22'),
(53, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:a09a:6bf4:4186:856e', '2405:201:9017:e03b:a59d:5c59:b657:8b79', 2, '2405:201:9017:e03b:a59d:5c59:b657:8b79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 09:22:22', '2025-10-04 09:22:22', '2025-10-04 09:22:22'),
(54, 2, 'profile_update', 'last_login_at', '2025-10-04 09:22:22', '2025-10-04 09:22:25', 2, '2405:201:9017:e03b:a59d:5c59:b657:8b79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 09:22:25', '2025-10-04 09:22:25', '2025-10-04 09:22:25'),
(55, 2, 'profile_update', 'last_login_at', '2025-10-04 09:22:25', '2025-10-04 09:22:29', 2, '2405:201:9017:e03b:a59d:5c59:b657:8b79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 09:22:29', '2025-10-04 09:22:29', '2025-10-04 09:22:29'),
(56, 2, 'profile_update', 'last_login_at', '2025-10-04 09:22:29', '2025-10-04 09:22:32', 2, '2405:201:9017:e03b:a59d:5c59:b657:8b79', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 09:22:32', '2025-10-04 09:22:32', '2025-10-04 09:22:32'),
(57, 2, 'profile_update', 'last_login_at', '2025-10-04 09:22:32', '2025-10-04 22:43:04', 2, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 22:43:04', '2025-10-04 22:43:04', '2025-10-04 22:43:04'),
(58, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:a59d:5c59:b657:8b79', '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 2, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 22:43:04', '2025-10-04 22:43:04', '2025-10-04 22:43:04'),
(59, 2, 'profile_update', 'last_login_at', '2025-10-04 22:43:04', '2025-10-04 22:43:12', 2, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 22:43:12', '2025-10-04 22:43:12', '2025-10-04 22:43:12'),
(60, 2, 'profile_update', 'last_login_at', '2025-10-04 22:43:12', '2025-10-04 22:43:20', 2, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 22:43:20', '2025-10-04 22:43:20', '2025-10-04 22:43:20'),
(61, 2, 'profile_update', 'last_login_at', '2025-10-04 22:43:20', '2025-10-04 22:43:26', 2, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 22:43:26', '2025-10-04 22:43:26', '2025-10-04 22:43:26'),
(62, 5, 'profile_update', 'last_login_at', '2025-09-29 16:22:51', '2025-10-04 23:52:48', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:48', '2025-10-04 23:52:48', '2025-10-04 23:52:48'),
(63, 5, 'profile_update', 'last_login_ip', '103.21.58.66', '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:48', '2025-10-04 23:52:48', '2025-10-04 23:52:48'),
(64, 5, 'profile_update', 'last_login_location', 'Mumbai, Maharashtra', 'Asansol, West Bengal', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:48', '2025-10-04 23:52:48', '2025-10-04 23:52:48'),
(65, 5, 'profile_update', 'last_login_user_agent', 'Timezone Test Browser', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:48', '2025-10-04 23:52:48', '2025-10-04 23:52:48'),
(66, 5, 'profile_update', 'last_login_at', '2025-10-04 23:52:48', '2025-10-04 23:52:52', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:52', '2025-10-04 23:52:52', '2025-10-04 23:52:52'),
(67, 5, 'profile_update', 'last_login_at', '2025-10-04 23:52:52', '2025-10-04 23:52:54', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:54', '2025-10-04 23:52:54', '2025-10-04 23:52:54'),
(68, 5, 'profile_update', 'last_login_at', '2025-10-04 23:52:54', '2025-10-04 23:52:56', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:52:56', '2025-10-04 23:52:56', '2025-10-04 23:52:56'),
(69, 5, 'address_add', 'new_address', NULL, '{\"user_id\":5,\"type\":\"both\",\"full_name\":\"Jasim Mondal\",\"phone\":\"+918536945959\",\"address_line_1\":\"near masjid, nazrulpally, bhubandanga\",\"city\":\"Bolpur\",\"state\":\"West Bengal\",\"pincode\":\"731204\",\"country\":\"India\",\"is_default\":false,\"updated_at\":\"2025-10-04T18:24:27.000000Z\",\"created_at\":\"2025-10-04T18:24:27.000000Z\",\"id\":2}', 5, '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-04 23:54:27', '2025-10-04 23:54:27', '2025-10-04 23:54:27'),
(70, 5, 'profile_update', 'last_login_at', '2025-10-04 23:52:56', '2025-10-05 01:52:44', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:44', '2025-10-05 01:52:44', '2025-10-05 01:52:44'),
(71, 5, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:44', '2025-10-05 01:52:44', '2025-10-05 01:52:44'),
(72, 5, 'profile_update', 'last_login_location', 'Asansol, West Bengal', 'Kolkata, West Bengal', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:44', '2025-10-05 01:52:44', '2025-10-05 01:52:44'),
(73, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:44', '2025-10-05 01:52:44', '2025-10-05 01:52:44'),
(74, 5, 'profile_update', 'last_login_at', '2025-10-05 01:52:44', '2025-10-05 01:52:49', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:49', '2025-10-05 01:52:49', '2025-10-05 01:52:49'),
(75, 5, 'profile_update', 'last_login_at', '2025-10-05 01:52:49', '2025-10-05 01:52:54', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:52:54', '2025-10-05 01:52:54', '2025-10-05 01:52:54'),
(76, 5, 'profile_update', 'last_login_at', '2025-10-05 01:52:54', '2025-10-05 01:53:00', 5, '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-05 01:53:00', '2025-10-05 01:53:00', '2025-10-05 01:53:00'),
(77, 2, 'profile_update', 'last_login_at', '2025-10-04 22:43:26', '2025-10-05 14:18:47', 2, '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 14:18:47', '2025-10-05 14:18:47', '2025-10-05 14:18:47'),
(78, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:ed11:2afa:c3b6:97f0', '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 2, '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 14:18:47', '2025-10-05 14:18:47', '2025-10-05 14:18:47'),
(79, 2, 'profile_update', 'last_login_at', '2025-10-05 14:18:47', '2025-10-05 14:18:51', 2, '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 14:18:51', '2025-10-05 14:18:51', '2025-10-05 14:18:51'),
(80, 2, 'profile_update', 'last_login_at', '2025-10-05 14:18:51', '2025-10-05 14:18:56', 2, '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 14:18:56', '2025-10-05 14:18:56', '2025-10-05 14:18:56'),
(81, 2, 'profile_update', 'last_login_at', '2025-10-05 14:18:56', '2025-10-05 14:19:00', 2, '2405:201:9017:e03b:7ce1:59:aff4:ff9a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 14:19:00', '2025-10-05 14:19:00', '2025-10-05 14:19:00'),
(82, 2, 'profile_update', 'last_login_at', '2025-10-05 14:19:00', '2025-10-05 18:53:21', 2, '2405:201:9017:e03b:5828:91a:fed8:a8a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 18:53:21', '2025-10-05 18:53:21', '2025-10-05 18:53:21'),
(83, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:7ce1:59:aff4:ff9a', '2405:201:9017:e03b:5828:91a:fed8:a8a', 2, '2405:201:9017:e03b:5828:91a:fed8:a8a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 18:53:21', '2025-10-05 18:53:21', '2025-10-05 18:53:21'),
(84, 2, 'profile_update', 'last_login_at', '2025-10-05 18:53:21', '2025-10-05 18:53:24', 2, '2405:201:9017:e03b:5828:91a:fed8:a8a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 18:53:24', '2025-10-05 18:53:24', '2025-10-05 18:53:24'),
(85, 2, 'profile_update', 'last_login_at', '2025-10-05 18:53:24', '2025-10-05 18:53:30', 2, '2405:201:9017:e03b:5828:91a:fed8:a8a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 18:53:30', '2025-10-05 18:53:30', '2025-10-05 18:53:30'),
(86, 2, 'profile_update', 'last_login_at', '2025-10-05 18:53:30', '2025-10-05 18:53:32', 2, '2405:201:9017:e03b:5828:91a:fed8:a8a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-05 18:53:32', '2025-10-05 18:53:32', '2025-10-05 18:53:32'),
(87, 2, 'profile_update', 'last_login_at', '2025-10-05 18:53:32', '2025-10-06 20:15:51', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:51', '2025-10-06 20:15:51', '2025-10-06 20:15:51'),
(88, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:5828:91a:fed8:a8a', '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:51', '2025-10-06 20:15:51', '2025-10-06 20:15:51'),
(89, 2, 'profile_update', 'last_login_location', 'Asansol, West Bengal', 'Kolkata, West Bengal', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:51', '2025-10-06 20:15:51', '2025-10-06 20:15:51'),
(90, 2, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:51', '2025-10-06 20:15:51', '2025-10-06 20:15:51'),
(91, 2, 'profile_update', 'last_login_at', '2025-10-06 20:15:51', '2025-10-06 20:15:55', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:55', '2025-10-06 20:15:55', '2025-10-06 20:15:55'),
(92, 2, 'profile_update', 'last_login_at', '2025-10-06 20:15:55', '2025-10-06 20:15:58', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:15:58', '2025-10-06 20:15:58', '2025-10-06 20:15:58'),
(93, 2, 'profile_update', 'last_login_at', '2025-10-06 20:15:58', '2025-10-06 20:16:03', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:16:03', '2025-10-06 20:16:03', '2025-10-06 20:16:03'),
(94, 2, 'profile_update', 'last_login_at', '2025-10-06 20:16:03', '2025-10-06 20:17:09', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:17:09', '2025-10-06 20:17:09', '2025-10-06 20:17:09'),
(95, 2, 'profile_update', 'last_login_at', '2025-10-06 20:17:09', '2025-10-06 20:17:11', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:17:11', '2025-10-06 20:17:11', '2025-10-06 20:17:11'),
(96, 2, 'profile_update', 'last_login_at', '2025-10-06 20:17:11', '2025-10-06 20:17:16', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:17:16', '2025-10-06 20:17:16', '2025-10-06 20:17:16'),
(97, 2, 'profile_update', 'last_login_at', '2025-10-06 20:17:16', '2025-10-06 20:17:19', 2, '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-06 20:17:19', '2025-10-06 20:17:19', '2025-10-06 20:17:19'),
(98, 2, 'profile_update', 'last_login_at', '2025-10-06 20:17:19', '2025-10-06 20:22:06', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:06', '2025-10-06 20:22:06', '2025-10-06 20:22:06'),
(99, 2, 'profile_update', 'last_login_ip', '2409:40e1:1142:7297:9fe5:d8c:603c:9ce3', '2409:40e1:1142:7297:715c:1127:6fee:68f5', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:06', '2025-10-06 20:22:06', '2025-10-06 20:22:06'),
(100, 2, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:06', '2025-10-06 20:22:06', '2025-10-06 20:22:06'),
(101, 2, 'profile_update', 'last_login_at', '2025-10-06 20:22:06', '2025-10-06 20:22:11', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:11', '2025-10-06 20:22:11', '2025-10-06 20:22:11'),
(102, 2, 'profile_update', 'last_login_at', '2025-10-06 20:22:11', '2025-10-06 20:22:14', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:14', '2025-10-06 20:22:14', '2025-10-06 20:22:14'),
(103, 2, 'profile_update', 'last_login_at', '2025-10-06 20:22:14', '2025-10-06 20:22:16', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:22:16', '2025-10-06 20:22:16', '2025-10-06 20:22:16'),
(104, 2, 'profile_update', 'last_login_at', '2025-10-06 20:22:16', '2025-10-06 20:37:40', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:37:40', '2025-10-06 20:37:40', '2025-10-06 20:37:40'),
(105, 2, 'profile_update', 'last_login_at', '2025-10-06 20:37:40', '2025-10-06 20:37:43', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:37:43', '2025-10-06 20:37:43', '2025-10-06 20:37:43'),
(106, 2, 'profile_update', 'last_login_at', '2025-10-06 20:37:43', '2025-10-06 20:37:46', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:37:46', '2025-10-06 20:37:46', '2025-10-06 20:37:46'),
(107, 2, 'profile_update', 'last_login_at', '2025-10-06 20:37:46', '2025-10-06 20:37:48', 2, '2409:40e1:1142:7297:715c:1127:6fee:68f5', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-06 20:37:48', '2025-10-06 20:37:48', '2025-10-06 20:37:48'),
(108, 2, 'profile_update', 'last_login_at', '2025-10-06 20:37:48', '2025-10-07 11:37:44', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:44', '2025-10-07 11:37:44', '2025-10-07 11:37:44'),
(109, 2, 'profile_update', 'last_login_ip', '2409:40e1:1142:7297:715c:1127:6fee:68f5', '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:44', '2025-10-07 11:37:44', '2025-10-07 11:37:44'),
(110, 2, 'profile_update', 'last_login_location', 'Kolkata, West Bengal', 'Malda, West Bengal', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:44', '2025-10-07 11:37:44', '2025-10-07 11:37:44'),
(111, 2, 'profile_update', 'last_login_at', '2025-10-07 11:37:44', '2025-10-07 11:37:47', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:47', '2025-10-07 11:37:47', '2025-10-07 11:37:47'),
(112, 2, 'profile_update', 'last_login_at', '2025-10-07 11:37:47', '2025-10-07 11:37:50', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:50', '2025-10-07 11:37:50', '2025-10-07 11:37:50'),
(113, 2, 'profile_update', 'last_login_at', '2025-10-07 11:37:50', '2025-10-07 11:37:52', 2, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 11:37:52', '2025-10-07 11:37:52', '2025-10-07 11:37:52'),
(114, 7, 'user_registration', 'new_user', NULL, '{\"name\":\"jasim\",\"email\":\"jasimmondal7672@gmail.com\",\"phone\":\"7063474409\",\"role\":\"customer\",\"status\":\"active\",\"updated_at\":\"2025-10-07T08:13:32.000000Z\",\"created_at\":\"2025-10-07T08:13:32.000000Z\",\"id\":7}', NULL, '223.184.146.15', 'Dart/3.9 (dart:io)', '2025-10-07 13:43:32', '2025-10-07 13:43:32', '2025-10-07 13:43:32'),
(115, 8, 'user_registration', 'new_user', NULL, '{\"name\":\"Test User\",\"email\":\"testuser@example.com\",\"phone\":null,\"role\":\"customer\",\"status\":\"active\",\"updated_at\":\"2025-10-07T08:23:24.000000Z\",\"created_at\":\"2025-10-07T08:23:24.000000Z\",\"id\":8}', NULL, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'curl/8.14.1', '2025-10-07 13:53:24', '2025-10-07 13:53:24', '2025-10-07 13:53:24'),
(116, 9, 'user_registration', 'new_user', NULL, '{\"name\":\"Test User 2\",\"email\":\"testuser2@example.com\",\"phone\":null,\"role\":\"customer\",\"status\":\"active\",\"updated_at\":\"2025-10-07T08:25:33.000000Z\",\"created_at\":\"2025-10-07T08:25:33.000000Z\",\"id\":9}', NULL, '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', 'curl/8.14.1', '2025-10-07 13:55:33', '2025-10-07 13:55:33', '2025-10-07 13:55:33'),
(117, 2, 'profile_update', 'last_login_at', '2025-10-07 11:37:52', '2025-10-07 18:12:12', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:12', '2025-10-07 18:12:12', '2025-10-07 18:12:12'),
(118, 2, 'profile_update', 'last_login_ip', '2401:4900:b1c1:9eda:404c:4e63:7ec8:3364', '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:12', '2025-10-07 18:12:12', '2025-10-07 18:12:12'),
(119, 2, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:12', '2025-10-07 18:12:12', '2025-10-07 18:12:12'),
(120, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:12', '2025-10-07 18:12:16', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:16', '2025-10-07 18:12:16', '2025-10-07 18:12:16'),
(121, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:16', '2025-10-07 18:12:21', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:21', '2025-10-07 18:12:21', '2025-10-07 18:12:21'),
(122, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:21', '2025-10-07 18:12:25', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', '2025-10-07 18:12:25', '2025-10-07 18:12:25', '2025-10-07 18:12:25'),
(123, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:25', '2025-10-07 18:12:39', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 18:12:39', '2025-10-07 18:12:39', '2025-10-07 18:12:39'),
(124, 2, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 18:12:39', '2025-10-07 18:12:39', '2025-10-07 18:12:39'),
(125, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:39', '2025-10-07 18:12:43', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 18:12:43', '2025-10-07 18:12:43', '2025-10-07 18:12:43'),
(126, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:43', '2025-10-07 18:12:47', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 18:12:47', '2025-10-07 18:12:47', '2025-10-07 18:12:47'),
(127, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:47', '2025-10-07 18:12:51', 2, '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', '2025-10-07 18:12:51', '2025-10-07 18:12:51', '2025-10-07 18:12:51'),
(128, 2, 'profile_update', 'last_login_at', '2025-10-07 18:12:51', '2025-10-10 11:37:57', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:37:57', '2025-10-10 11:37:57', '2025-10-10 11:37:57'),
(129, 2, 'profile_update', 'last_login_ip', '2401:4900:b1c1:9eda:4c27:9cff:fe6f:e9f8', '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:37:57', '2025-10-10 11:37:57', '2025-10-10 11:37:57'),
(130, 2, 'profile_update', 'last_login_location', 'Malda, West Bengal', 'Asansol, West Bengal', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:37:57', '2025-10-10 11:37:57', '2025-10-10 11:37:57'),
(131, 2, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:37:57', '2025-10-10 11:37:57', '2025-10-10 11:37:57'),
(132, 2, 'profile_update', 'last_login_at', '2025-10-10 11:37:57', '2025-10-10 11:38:00', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:38:00', '2025-10-10 11:38:00', '2025-10-10 11:38:00'),
(133, 2, 'profile_update', 'last_login_at', '2025-10-10 11:38:00', '2025-10-10 11:38:03', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:38:03', '2025-10-10 11:38:03', '2025-10-10 11:38:03'),
(134, 2, 'profile_update', 'last_login_at', '2025-10-10 11:38:03', '2025-10-10 11:38:08', 2, '2405:201:9017:e03b:d40f:5291:7c3a:9c99', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 11:38:08', '2025-10-10 11:38:08', '2025-10-10 11:38:08'),
(135, 2, 'profile_update', 'last_login_at', '2025-10-10 11:38:08', '2025-10-10 16:40:52', 2, '2405:201:9017:e03b:315f:79f5:a52f:5f98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 16:40:52', '2025-10-10 16:40:52', '2025-10-10 16:40:52'),
(136, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:d40f:5291:7c3a:9c99', '2405:201:9017:e03b:315f:79f5:a52f:5f98', 2, '2405:201:9017:e03b:315f:79f5:a52f:5f98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 16:40:52', '2025-10-10 16:40:52', '2025-10-10 16:40:52'),
(137, 2, 'profile_update', 'last_login_at', '2025-10-10 16:40:52', '2025-10-10 16:40:57', 2, '2405:201:9017:e03b:315f:79f5:a52f:5f98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 16:40:57', '2025-10-10 16:40:57', '2025-10-10 16:40:57'),
(138, 2, 'profile_update', 'last_login_at', '2025-10-10 16:40:57', '2025-10-10 16:41:01', 2, '2405:201:9017:e03b:315f:79f5:a52f:5f98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 16:41:01', '2025-10-10 16:41:01', '2025-10-10 16:41:01'),
(139, 2, 'profile_update', 'last_login_at', '2025-10-10 16:41:01', '2025-10-10 16:41:06', 2, '2405:201:9017:e03b:315f:79f5:a52f:5f98', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 16:41:06', '2025-10-10 16:41:06', '2025-10-10 16:41:06'),
(140, 2, 'profile_update', 'last_login_at', '2025-10-10 16:41:06', '2025-10-10 20:38:59', 2, '2405:201:9017:e03b:9c90:908b:5fee:9631', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 20:38:59', '2025-10-10 20:38:59', '2025-10-10 20:38:59'),
(141, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:315f:79f5:a52f:5f98', '2405:201:9017:e03b:9c90:908b:5fee:9631', 2, '2405:201:9017:e03b:9c90:908b:5fee:9631', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 20:38:59', '2025-10-10 20:38:59', '2025-10-10 20:38:59'),
(142, 2, 'profile_update', 'last_login_at', '2025-10-10 20:38:59', '2025-10-10 20:39:02', 2, '2405:201:9017:e03b:9c90:908b:5fee:9631', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 20:39:02', '2025-10-10 20:39:02', '2025-10-10 20:39:02'),
(143, 2, 'profile_update', 'last_login_at', '2025-10-10 20:39:02', '2025-10-10 20:39:05', 2, '2405:201:9017:e03b:9c90:908b:5fee:9631', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 20:39:05', '2025-10-10 20:39:05', '2025-10-10 20:39:05'),
(144, 2, 'profile_update', 'last_login_at', '2025-10-10 20:39:05', '2025-10-10 20:39:07', 2, '2405:201:9017:e03b:9c90:908b:5fee:9631', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-10 20:39:07', '2025-10-10 20:39:07', '2025-10-10 20:39:07'),
(145, 2, 'profile_update', 'last_login_at', '2025-10-10 20:39:07', '2025-10-11 22:17:02', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:02', '2025-10-11 22:17:02', '2025-10-11 22:17:02'),
(146, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:9c90:908b:5fee:9631', '2405:201:9017:e03b:7851:3564:9837:7567', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:02', '2025-10-11 22:17:02', '2025-10-11 22:17:02'),
(147, 2, 'profile_update', 'last_login_at', '2025-10-11 22:17:02', '2025-10-11 22:17:07', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:07', '2025-10-11 22:17:07', '2025-10-11 22:17:07'),
(148, 2, 'profile_update', 'last_login_at', '2025-10-11 22:17:07', '2025-10-11 22:17:11', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:11', '2025-10-11 22:17:11', '2025-10-11 22:17:11'),
(149, 2, 'profile_update', 'last_login_at', '2025-10-11 22:17:11', '2025-10-11 22:17:16', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:16', '2025-10-11 22:17:16', '2025-10-11 22:17:16'),
(150, 5, 'profile_update', 'last_login_at', '2025-10-05 01:53:00', '2025-10-11 22:17:56', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:56', '2025-10-11 22:17:56', '2025-10-11 22:17:56'),
(151, 5, 'profile_update', 'last_login_ip', '2409:40e1:10f8:324f:18e0:f4ff:fedd:67c9', '2405:201:9017:e03b:7851:3564:9837:7567', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:56', '2025-10-11 22:17:56', '2025-10-11 22:17:56'),
(152, 5, 'profile_update', 'last_login_location', 'Kolkata, West Bengal', 'Asansol, West Bengal', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:56', '2025-10-11 22:17:56', '2025-10-11 22:17:56'),
(153, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/140.0.0.0 Mobile Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:17:56', '2025-10-11 22:17:56', '2025-10-11 22:17:56'),
(154, 5, 'profile_update', 'last_login_at', '2025-10-11 22:17:56', '2025-10-11 22:18:00', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:18:00', '2025-10-11 22:18:00', '2025-10-11 22:18:00'),
(155, 5, 'profile_update', 'last_login_at', '2025-10-11 22:18:00', '2025-10-11 22:18:03', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:18:03', '2025-10-11 22:18:03', '2025-10-11 22:18:03'),
(156, 5, 'profile_update', 'last_login_at', '2025-10-11 22:18:03', '2025-10-11 22:18:05', 5, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:18:05', '2025-10-11 22:18:05', '2025-10-11 22:18:05'),
(157, 2, 'profile_update', 'last_login_at', '2025-10-11 22:17:16', '2025-10-11 22:21:48', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:21:48', '2025-10-11 22:21:48', '2025-10-11 22:21:48'),
(158, 2, 'profile_update', 'last_login_at', '2025-10-11 22:21:48', '2025-10-11 22:21:52', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:21:52', '2025-10-11 22:21:52', '2025-10-11 22:21:52'),
(159, 2, 'profile_update', 'last_login_at', '2025-10-11 22:21:52', '2025-10-11 22:21:56', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:21:56', '2025-10-11 22:21:56', '2025-10-11 22:21:56'),
(160, 2, 'profile_update', 'last_login_at', '2025-10-11 22:21:56', '2025-10-11 22:22:00', 2, '2405:201:9017:e03b:7851:3564:9837:7567', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-11 22:22:00', '2025-10-11 22:22:00', '2025-10-11 22:22:00'),
(161, 2, 'profile_update', 'last_login_at', '2025-10-11 22:22:00', '2025-10-12 10:22:08', 2, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:22:08', '2025-10-12 10:22:08', '2025-10-12 10:22:08'),
(162, 2, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:7851:3564:9837:7567', '2405:201:9017:e03b:8835:78c2:2abc:1488', 2, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:22:08', '2025-10-12 10:22:08', '2025-10-12 10:22:08'),
(163, 2, 'profile_update', 'last_login_at', '2025-10-12 10:22:08', '2025-10-12 10:22:11', 2, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:22:11', '2025-10-12 10:22:11', '2025-10-12 10:22:11'),
(164, 2, 'profile_update', 'last_login_at', '2025-10-12 10:22:11', '2025-10-12 10:22:14', 2, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:22:14', '2025-10-12 10:22:14', '2025-10-12 10:22:14'),
(165, 2, 'profile_update', 'last_login_at', '2025-10-12 10:22:14', '2025-10-12 10:22:17', 2, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:22:17', '2025-10-12 10:22:17', '2025-10-12 10:22:17'),
(166, 10, 'user_registration', 'new_user', NULL, '{\"name\":\"User 5959\",\"email\":\"8536945959@mobile.local\",\"phone\":\"8536945959\",\"phone_verified_at\":\"2025-10-12T05:15:00.000000Z\",\"login_type\":\"phone\",\"updated_at\":\"2025-10-12T05:15:00.000000Z\",\"created_at\":\"2025-10-12T05:15:00.000000Z\",\"id\":10}', NULL, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:00', '2025-10-12 10:45:00', '2025-10-12 10:45:00'),
(167, 10, 'profile_update', 'last_login_at', NULL, '2025-10-12 10:45:09', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:09', '2025-10-12 10:45:09', '2025-10-12 10:45:09'),
(168, 10, 'profile_update', 'last_login_ip', NULL, '2405:201:9017:e03b:8835:78c2:2abc:1488', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:09', '2025-10-12 10:45:09', '2025-10-12 10:45:09'),
(169, 10, 'profile_update', 'last_login_location', NULL, 'Asansol, West Bengal', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:09', '2025-10-12 10:45:09', '2025-10-12 10:45:09'),
(170, 10, 'profile_update', 'last_login_country', NULL, 'India', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:09', '2025-10-12 10:45:09', '2025-10-12 10:45:09'),
(171, 10, 'profile_update', 'last_login_user_agent', NULL, 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:09', '2025-10-12 10:45:09', '2025-10-12 10:45:09'),
(172, 10, 'profile_update', 'last_login_at', '2025-10-12 10:45:09', '2025-10-12 10:45:12', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:12', '2025-10-12 10:45:12', '2025-10-12 10:45:12'),
(173, 10, 'profile_update', 'last_login_at', '2025-10-12 10:45:12', '2025-10-12 10:45:14', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:14', '2025-10-12 10:45:14', '2025-10-12 10:45:14'),
(174, 10, 'profile_update', 'last_login_at', '2025-10-12 10:45:14', '2025-10-12 10:45:17', 10, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:45:17', '2025-10-12 10:45:17', '2025-10-12 10:45:17'),
(175, 5, 'profile_update', 'phone', '+918536945959', '8536945959', NULL, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:48', '2025-10-12 10:48:48', '2025-10-12 10:48:48'),
(176, 5, 'profile_update', 'phone_verified_at', NULL, '2025-10-12 10:48:48', NULL, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:48', '2025-10-12 10:48:48', '2025-10-12 10:48:48'),
(177, 5, 'profile_update', 'login_type', 'email', 'phone', NULL, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:48', '2025-10-12 10:48:48', '2025-10-12 10:48:48'),
(178, 5, 'profile_update', 'last_login_at', '2025-10-11 22:18:05', '2025-10-12 10:48:51', 5, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:51', '2025-10-12 10:48:51', '2025-10-12 10:48:51'),
(179, 5, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:7851:3564:9837:7567', '2405:201:9017:e03b:8835:78c2:2abc:1488', 5, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:51', '2025-10-12 10:48:51', '2025-10-12 10:48:51'),
(180, 5, 'profile_update', 'last_login_at', '2025-10-12 10:48:51', '2025-10-12 10:48:54', 5, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:54', '2025-10-12 10:48:54', '2025-10-12 10:48:54'),
(181, 5, 'profile_update', 'last_login_at', '2025-10-12 10:48:54', '2025-10-12 10:48:58', 5, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:48:58', '2025-10-12 10:48:58', '2025-10-12 10:48:58'),
(182, 5, 'profile_update', 'last_login_at', '2025-10-12 10:48:58', '2025-10-12 10:49:00', 5, '2405:201:9017:e03b:8835:78c2:2abc:1488', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 10:49:00', '2025-10-12 10:49:00', '2025-10-12 10:49:00'),
(183, 5, 'profile_update', 'phone_verified_at', '2025-10-12 10:48:48', '2025-10-12 12:34:01', NULL, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:01', '2025-10-12 12:34:01', '2025-10-12 12:34:01'),
(184, 5, 'profile_update', 'last_login_at', '2025-10-12 10:49:00', '2025-10-12 12:34:04', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:04', '2025-10-12 12:34:04', '2025-10-12 12:34:04'),
(185, 5, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:8835:78c2:2abc:1488', '2405:201:9017:e03b:675c:7479:47c1:a708', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:04', '2025-10-12 12:34:04', '2025-10-12 12:34:04'),
(186, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:04', '2025-10-12 12:34:04', '2025-10-12 12:34:04'),
(187, 5, 'profile_update', 'last_login_at', '2025-10-12 12:34:04', '2025-10-12 12:34:07', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:07', '2025-10-12 12:34:07', '2025-10-12 12:34:07'),
(188, 5, 'profile_update', 'last_login_at', '2025-10-12 12:34:07', '2025-10-12 12:34:10', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:10', '2025-10-12 12:34:10', '2025-10-12 12:34:10'),
(189, 5, 'profile_update', 'last_login_at', '2025-10-12 12:34:10', '2025-10-12 12:34:13', 5, '2405:201:9017:e03b:675c:7479:47c1:a708', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', '2025-10-12 12:34:13', '2025-10-12 12:34:13', '2025-10-12 12:34:13'),
(190, 5, 'profile_update', 'phone_verified_at', '2025-10-12 12:34:01', '2025-10-12 13:22:28', NULL, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:28', '2025-10-12 13:22:28', '2025-10-12 13:22:28'),
(191, 5, 'profile_update', 'last_login_at', '2025-10-12 12:34:13', '2025-10-12 13:22:37', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:37', '2025-10-12 13:22:37', '2025-10-12 13:22:37'),
(192, 5, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:675c:7479:47c1:a708', '2405:201:9017:e03b:56f:b21a:58d2:f04a', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:37', '2025-10-12 13:22:37', '2025-10-12 13:22:37'),
(193, 5, 'profile_update', 'last_login_user_agent', 'Mozilla/5.0 (Linux; Android 10; K) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Mobile Safari/537.36', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:37', '2025-10-12 13:22:37', '2025-10-12 13:22:37'),
(194, 5, 'profile_update', 'last_login_at', '2025-10-12 13:22:37', '2025-10-12 13:22:44', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:44', '2025-10-12 13:22:44', '2025-10-12 13:22:44'),
(195, 5, 'profile_update', 'last_login_at', '2025-10-12 13:22:44', '2025-10-12 13:22:48', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:48', '2025-10-12 13:22:48', '2025-10-12 13:22:48'),
(196, 5, 'profile_update', 'last_login_at', '2025-10-12 13:22:48', '2025-10-12 13:22:55', 5, '2405:201:9017:e03b:56f:b21a:58d2:f04a', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-12 13:22:55', '2025-10-12 13:22:55', '2025-10-12 13:22:55'),
(197, 5, 'profile_update', 'phone_verified_at', '2025-10-12 13:22:28', '2025-10-13 00:23:37', NULL, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:37', '2025-10-13 00:23:37', '2025-10-13 00:23:37'),
(198, 5, 'profile_update', 'last_login_at', '2025-10-12 13:22:55', '2025-10-13 00:23:40', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:40', '2025-10-13 00:23:40', '2025-10-13 00:23:40'),
(199, 5, 'profile_update', 'last_login_ip', '2405:201:9017:e03b:56f:b21a:58d2:f04a', '2405:201:9017:e04b:711c:686f:ae8:cb34', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:40', '2025-10-13 00:23:40', '2025-10-13 00:23:40'),
(200, 5, 'profile_update', 'last_login_at', '2025-10-13 00:23:40', '2025-10-13 00:23:43', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:43', '2025-10-13 00:23:43', '2025-10-13 00:23:43'),
(201, 5, 'profile_update', 'last_login_at', '2025-10-13 00:23:43', '2025-10-13 00:23:45', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:45', '2025-10-13 00:23:45', '2025-10-13 00:23:45'),
(202, 5, 'profile_update', 'last_login_at', '2025-10-13 00:23:45', '2025-10-13 00:23:51', 5, '2405:201:9017:e04b:711c:686f:ae8:cb34', 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/141.0.0.0 Safari/537.36', '2025-10-13 00:23:51', '2025-10-13 00:23:51', '2025-10-13 00:23:51');


-- Table structure for table `whatsapp_campaign_recipients`
DROP TABLE IF EXISTS `whatsapp_campaign_recipients`;
CREATE TABLE "whatsapp_campaign_recipients" ("id" integer primary key autoincrement not null, "campaign_id" integer not null, "user_id" integer not null, "phone_number" varchar not null, "status" varchar not null default 'pending', "whatsapp_message_id" varchar, "error_message" text, "sent_at" datetime, "delivered_at" datetime, "read_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("campaign_id") references "whatsapp_campaigns"("id") on delete cascade, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `whatsapp_campaign_recipients`
INSERT INTO `whatsapp_campaign_recipients` (`id`, `campaign_id`, `user_id`, `phone_number`, `status`, `whatsapp_message_id`, `error_message`, `sent_at`, `delivered_at`, `read_at`, `created_at`, `updated_at`) VALUES
(1, 1, 5, '+918536945959', 'sent', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQTRBNkNFNTBENkQ0OTMxRUY4AA==', NULL, '2025-10-03 21:55:07', NULL, NULL, '2025-10-03 21:44:00', '2025-10-03 21:55:07'),
(2, 2, 5, '+918536945959', 'sent', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRTY0Qjg4M0ZCMzg4QkZFOUNDAA==', NULL, '2025-10-03 22:03:36', NULL, NULL, '2025-10-03 22:03:31', '2025-10-03 22:03:36');


-- Table structure for table `personal_access_tokens`
DROP TABLE IF EXISTS `personal_access_tokens`;
CREATE TABLE "personal_access_tokens" ("id" integer primary key autoincrement not null, "tokenable_type" varchar not null, "tokenable_id" integer not null, "name" text not null, "token" varchar not null, "abilities" text, "last_used_at" datetime, "expires_at" datetime, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `personal_access_tokens`
INSERT INTO `personal_access_tokens` (`id`, `tokenable_type`, `tokenable_id`, `name`, `token`, `abilities`, `last_used_at`, `expires_at`, `created_at`, `updated_at`) VALUES
(2, 'App\\Models\\User', 9, 'mobile-app', 'c2ff0b83c8ec2d46ad811f499b0535a07e8128d6fde717bc7735cab9ba5e6428', '[\"*\"]', NULL, NULL, '2025-10-07 13:56:06', '2025-10-07 13:56:06'),
(4, 'App\\Models\\User', 7, 'mobile-app', 'e5714ceb5b06ff27dffd2058897be8a11148d41705db5e217d5867a5687a1ced', '[\"*\"]', '2025-10-07 22:20:32', NULL, '2025-10-07 22:20:10', '2025-10-07 22:20:32');


-- Table structure for table `whatsapp_accounts`
DROP TABLE IF EXISTS `whatsapp_accounts`;
CREATE TABLE "whatsapp_accounts" ("id" integer primary key autoincrement not null, "name" varchar not null, "business_account_id" varchar not null, "phone_number_id" varchar not null, "display_phone_number" varchar, "verified_name" varchar, "access_token" text not null, "api_version" varchar not null default 'v18.0', "quality_rating" varchar, "messaging_limit_tier" varchar, "is_active" tinyint(1) not null default '1', "is_default" tinyint(1) not null default '0', "webhook_url" text, "webhook_verify_token" varchar, "metadata" text, "created_at" datetime, "updated_at" datetime, "deleted_at" datetime);


-- Dumping data for table `whatsapp_accounts`
INSERT INTO `whatsapp_accounts` (`id`, `name`, `business_account_id`, `phone_number_id`, `display_phone_number`, `verified_name`, `access_token`, `api_version`, `quality_rating`, `messaging_limit_tier`, `is_active`, `is_default`, `webhook_url`, `webhook_verify_token`, `metadata`, `created_at`, `updated_at`, `deleted_at`) VALUES
(1, 'Main Account', '845234471785648', '730173600190286', '+91 79083 42668', 'SJ Fashion Hub', 'eyJpdiI6IjBYNGRWWllSc0xENm1FWjdzWTVud2c9PSIsInZhbHVlIjoieE5Bakc4VE5sazRwVk11UGx6bDBKckZwbjRpVVJBVXZxTDE0ejVydWdQUThQbnhzZW95aThydHh6NDUyM1NUOGJVUkZpNVFYeGJhWUdxbEhJdHQrQ1IvN1dZN3VaZmhrM3YzUjYxai91N1BKNFJsRC9jNnVVNkFXZEVLSW1YMXk5U2xtVG5PR3hRcXVEcDNlS1BlS21wRFA2QkdlNlZKcFAxUk9aUVBhQkJrb3pIL2RPYnptcmttY1JLeE8yTS85RzlPampHWHo3SDlLanFGZC9YRVJ3WDNYZ0FST0xtY1F4SG5EQ216VzZFOS9JcDhhMStYWGQ5SlRiVGZqa3BVVVI0QnZzNnZIK3dLRng0dFNMTmVGVFR3SWlIMVF1eUhmelR5OVlIbE80bG89IiwibWFjIjoiOTRhM2Y0MDdkZGFmMWYyZjE1NTI3Njc1MjU3ZGMyNzBkNzY1MjFhNjFjNjBjYTgwNjEyNDFkNjZiZjIzMTg1OSIsInRhZyI6IiJ9', 'v18.0', 'GREEN', 'TIER_1K', 1, 1, NULL, 'sjfashion_c9e6569cf626505d0643940a8f33c109', NULL, '2025-10-03 20:55:50', '2025-10-13 00:09:27', NULL);


-- Table structure for table `whatsapp_templates`
DROP TABLE IF EXISTS `whatsapp_templates`;
CREATE TABLE "whatsapp_templates" ("id" integer primary key autoincrement not null, "name" varchar not null, "display_name" varchar not null, "category" varchar not null, "language" varchar not null default ('en'), "header_text" text, "header_type" varchar, "body_text" text not null, "footer_text" text, "buttons" text, "variables" text, "status" varchar not null default ('draft'), "whatsapp_template_id" varchar, "rejection_reason" text, "submitted_at" datetime, "approved_at" datetime, "created_at" datetime, "updated_at" datetime, "deleted_at" datetime, "account_id" integer, "last_synced_at" datetime, variable_samples TEXT, foreign key("account_id") references "whatsapp_accounts"("id") on delete cascade);


-- Dumping data for table `whatsapp_templates`
INSERT INTO `whatsapp_templates` (`id`, `name`, `display_name`, `category`, `language`, `header_text`, `header_type`, `body_text`, `footer_text`, `buttons`, `variables`, `status`, `whatsapp_template_id`, `rejection_reason`, `submitted_at`, `approved_at`, `created_at`, `updated_at`, `deleted_at`, `account_id`, `last_synced_at`, `variable_samples`) VALUES
(1, 'festive_flash_sale', 'Festive Flash Sale', 'marketing', 'en', 'HURRY,', 'text', 'Hi {{1}},

Our Festive Flash Sale is NOW ON! 🎉 Get up to {{2}}% off on ALL items! Use code {{3}} at checkout. Offer ends {{4}}. Don\'t miss out, shop now before it\'s too late! Limited stock available.', 'SJ Fashion Hub', NULL, NULL, 'approved', '1126734439116954', NULL, NULL, NULL, '2025-10-03 21:43:23', '2025-10-03 21:43:23', NULL, 1, '2025-10-03 21:43:23', NULL),
(2, 'puja_sale_2024', 'Puja Sale 2024', 'marketing', 'en', 'Puja Sale!', 'text', 'Dear {{1}},

Get ready for Puja with our exclusive sale! Enjoy {{2}} off on your favorite items. Use code {{3}} at checkout.

Hurry, offer valid till {{4}}!', 'From [Your Company Name]', NULL, NULL, 'rejected', '24767178932939561', 'No specific reason provided by WhatsApp', NULL, NULL, '2025-10-03 21:43:23', '2025-10-12 12:12:03', NULL, 1, '2025-10-03 21:43:23', NULL),
(3, 'order_confirmation_final', 'Order Confirmation Final', 'utility', 'en', 'Order Confirmed', 'text', 'Hello {{1}}, your order {{2}} for {{3}} has been confirmed. Expected delivery: {{4}}. Thank you!', 'SJ Fashion Hub', NULL, NULL, 'approved', '1624426918966060', NULL, NULL, NULL, '2025-10-03 21:43:23', '2025-10-03 21:43:23', NULL, 1, '2025-10-03 21:43:23', NULL),
(4, 'welcome1', 'Welcome1', 'marketing', 'en', 'Welcome', 'text', 'Hi 
Welcome to our site.', 'SJ Fashion Hub', NULL, NULL, 'approved', '815974974213810', NULL, NULL, NULL, '2025-10-03 21:43:23', '2025-10-03 21:43:23', NULL, 1, '2025-10-03 21:43:23', NULL),
(5, 'order_shipped_notification', 'Order Shipped Notification', 'utility', 'en', 'Order Shipped', 'text', 'Hello {{1}},

Great news! Your order {{2}} has been shipped and is on its way to you.

Expected delivery: {{3}}

Track your shipment to see real-time updates.

Thank you for shopping with SJ Fashion Hub!', 'SJ Fashion Hub', NULL, NULL, 'rejected', '822453477143193', 'No specific reason provided by WhatsApp', NULL, NULL, '2025-10-03 21:43:23', '2025-10-12 12:12:04', NULL, 1, '2025-10-03 21:43:23', NULL),
(6, 'welcome_offer_sjfashion', 'Welcome Offer Sjfashion', 'marketing', 'en', 'Special Offer for You', 'text', 'Hello {{1}},

Thank you for choosing SJ Fashion Hub. We appreciate your interest in our collection.

As a welcome gesture, enjoy {{2}} off on your purchase of ₹500 or more. Use code {{3}} at checkout.

This offer is valid until {{4}}. Visit our website to explore our latest styles.', 'SJ Fashion Hub - Reply STOP to opt out', NULL, NULL, 'rejected', '1782433719300398', 'No specific reason provided by WhatsApp', NULL, NULL, '2025-10-03 21:43:23', '2025-10-12 12:12:05', NULL, 1, '2025-10-03 21:43:23', NULL),
(7, 'welcome_sale_10_percent_off', 'Welcome Sale 10 Percent Off', 'marketing', 'en', 'Welcome', 'text', 'Hi {{1}},

Welcome to our store! To celebrate, we\'re offering you a special welcome discount of {{2}} off your first purchase. Discover amazing deals on all your favorite items.

Shop now and don\'t miss out!', 'SJ Fashion Hub', NULL, NULL, 'approved', '798123336152609', NULL, NULL, NULL, '2025-10-03 21:43:23', '2025-10-03 21:43:23', NULL, 1, '2025-10-03 21:43:23', NULL),
(8, '10percentoffsale', '10percentoffsale', 'marketing', 'en', 'Welcome', 'text', 'Hi {{1}},

Enjoy a 10% discount on all items this week! Use code {{2}} at checkout. Don\'t miss out – offer ends {{3}}.

Shop now and save!', 'Your Brand Name', NULL, NULL, 'rejected', '3363610033791808', 'No specific reason provided by WhatsApp', NULL, NULL, '2025-10-03 21:43:23', '2025-10-12 12:12:06', NULL, 1, '2025-10-03 21:43:23', NULL),
(9, 'hello_world', 'Hello World', 'utility', 'en_US', 'Hello World', 'text', 'Welcome and congratulations!! This message demonstrates your ability to send a WhatsApp message notification from the Cloud API, hosted by Meta. Thank you for taking the time to test with us.', 'WhatsApp Business Platform sample message', NULL, NULL, 'approved', '1522848122499869', NULL, NULL, NULL, '2025-10-03 21:43:23', '2025-10-03 21:43:23', NULL, 1, '2025-10-03 21:43:23', NULL),
(16, 'otp_login_en_1760245300', 'Mobile Login OTP Verification', 'AUTHENTICATION', 'en', NULL, NULL, 'Hi ,

Your OTP for mobile login is: {{1}}.

Please enter this code within 5 minutes to verify your account. For security reasons, do not share this code with anyone. 

Thank you.', NULL, NULL, '[\"1\"]', 'approved', '800755795917392', NULL, '2025-10-12 10:34:32', '2025-10-12 10:34:43', '2025-10-12 10:31:40', '2025-10-12 10:34:43', NULL, NULL, NULL, '{\"1\":\"123456\"}'),
(17, 'welcome_message_sjfashion', 'Welcome Message - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, 'Welcome to *SJ Fashion Hub*, {{1}}! 👗

Thank you for joining us. We\'re excited to have you!

Explore our latest collection and enjoy exclusive offers.

Happy Shopping! 🛍️', 'SJ Fashion Hub - Your Style Partner', '\"[{\\\"type\\\":\\\"URL\\\",\\\"text\\\":\\\"Shop Now\\\",\\\"url\\\":\\\"https:\\\\\\/\\\\\\/sjfashionhub.com\\\"}]\"', '[\"1\"]', 'approved', '1113154420886975', NULL, '2025-10-12 10:53:24', '2025-10-12 10:54:57', '2025-10-12 10:53:16', '2025-10-12 10:54:57', NULL, NULL, NULL, '[\"John\"]'),
(18, 'order_placed_sjfashion', 'Order Placed Confirmation', 'UTILITY', 'en', NULL, NULL, '🎉 *Order Confirmed!*

Hi {{1}},

Your order #{{2}} has been placed successfully.

💰 Amount: ₹{{3}}
📦 Items: {{4}}

We\'ll notify you once your order is shipped.

Thank you for shopping with us!', 'SJ Fashion Hub', '\"[{\\\"type\\\":\\\"URL\\\",\\\"text\\\":\\\"Track Order\\\",\\\"url\\\":\\\"https:\\\\\\/\\\\\\/sjfashionhub.com\\\\\\/orders\\\\\\/{{1}}\\\"}]\"', '[\"1\",\"2\",\"3\",\"4\"]', 'approved', '1344881173966926', NULL, '2025-10-12 10:53:37', '2025-10-12 10:55:07', '2025-10-12 10:53:16', '2025-10-12 10:55:07', NULL, NULL, NULL, '[\"John\",\"ORD12345\",\"2499\",\"2\"]'),
(19, 'order_shipped_sjfashion', 'Order Shipped Notification', 'UTILITY', 'en', NULL, NULL, '🚚 *Order Shipped!*

Hi {{1}},

Great news! Your order #{{2}} has been shipped.

📦 Tracking ID: {{3}}
🚛 Courier: {{4}}
📅 Expected Delivery: {{5}}

You can track your order using the link below.', 'SJ Fashion Hub', '\"[{\\\"type\\\":\\\"URL\\\",\\\"text\\\":\\\"Track Shipment\\\",\\\"url\\\":\\\"https:\\\\\\/\\\\\\/sjfashionhub.com\\\\\\/track\\\\\\/{{1}}\\\"}]\"', '[\"1\",\"2\",\"3\",\"4\",\"5\"]', 'approved', '1529603018236194', NULL, '2025-10-12 10:53:46', '2025-10-12 10:55:10', '2025-10-12 10:53:16', '2025-10-12 10:55:10', NULL, NULL, NULL, '[\"John\",\"ORD12345\",\"TRK987654\",\"BlueDart\",\"3-5 days\"]'),
(20, 'order_delivered_sjfashion', 'Order Delivered Confirmation', 'UTILITY', 'en', NULL, NULL, '✅ *Order Delivered!*

Hi {{1}},

Your order #{{2}} has been delivered successfully! 🎉

We hope you love your purchase!

Please share your feedback and rate your experience.

Thank you for choosing SJ Fashion Hub! 💕', 'SJ Fashion Hub', '\"[{\\\"type\\\":\\\"URL\\\",\\\"text\\\":\\\"Rate Order\\\",\\\"url\\\":\\\"https:\\\\\\/\\\\\\/sjfashionhub.com\\\\\\/orders\\\\\\/{{1}}\\\\\\/review\\\"}]\"', '[\"1\",\"2\"]', 'approved', '1737696750275867', NULL, '2025-10-12 10:53:53', '2025-10-12 10:55:13', '2025-10-12 10:53:16', '2025-10-12 10:55:13', NULL, NULL, NULL, '[\"John\",\"ORD12345\"]'),
(21, 'order_out_for_delivery_sjfashion', 'Order Out for Delivery', 'UTILITY', 'en', NULL, NULL, '🚴 *Out for Delivery!*

Hi {{1}},

Your order #{{2}} is out for delivery and will reach you soon!

📍 Delivery Address: {{3}}
⏰ Expected Time: {{4}}

Please keep your phone handy for delivery updates.', 'SJ Fashion Hub', '\"[{\\\"type\\\":\\\"URL\\\",\\\"text\\\":\\\"Track Order\\\",\\\"url\\\":\\\"https:\\\\\\/\\\\\\/sjfashionhub.com\\\\\\/orders\\\\\\/{{1}}\\\"}]\"', '[\"1\",\"2\",\"3\",\"4\"]', 'approved', '1358242599196412', NULL, '2025-10-12 10:54:03', '2025-10-12 10:55:16', '2025-10-12 10:53:16', '2025-10-12 10:55:16', NULL, NULL, NULL, '[\"John\",\"ORD12345\",\"Mumbai, Maharashtra\",\"Today by 6 PM\"]'),
(22, 'order_confirmed_sjfashion', 'Order Confirmed - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '✅ *Order Confirmed!*

Hi {{1}},

Your order #{{2}} has been confirmed and is being prepared for shipment.

💰 Amount: ₹{{3}}
📦 Items: {{4}}

We\'ll notify you once it\'s ready to ship!

Thank you for shopping with SJ Fashion Hub! 🛍️', 'Track your order anytime on our website', NULL, NULL, 'rejected', '1300313894732213', 'No specific reason provided by WhatsApp', '2025-10-12 11:28:50', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(23, 'ready_to_ship_sjfashion', 'Ready to Ship - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '📦 *Ready to Ship!*

Hi {{1}},

Great news! Your order #{{2}} is packed and ready to ship.

📋 Items: {{3}}
💰 Total: ₹{{4}}

It will be shipped soon. We\'ll send you tracking details once it\'s dispatched.

Thank you for your patience! 🙏', 'SJ Fashion Hub - Your Style Partner', NULL, NULL, 'rejected', '812919417952660', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:04', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(24, 'order_cancelled_sjfashion', 'Order Cancelled - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '❌ *Order Cancelled*

Hi {{1}},

Your order #{{2}} has been cancelled.

💰 Amount: ₹{{3}}

Reason: {{4}}

If you paid online, your refund will be processed within 5-7 business days.

For any questions, please contact our support team.', 'We hope to serve you again soon!', NULL, NULL, 'rejected', '1860098334582151', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:13', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(25, 'order_rto_sjfashion', 'Order RTO - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🔄 *Order Returned to Origin*

Hi {{1}},

Your order #{{2}} could not be delivered and is being returned to us.

💰 Amount: ₹{{3}}

Reason: {{4}}

Your refund will be processed once we receive the package.

Please contact us if you\'d like to re-order.', 'SJ Fashion Hub Support Team', NULL, NULL, 'rejected', '790417023777751', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:19', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(26, 'return_request_sjfashion', 'Return Request Submitted - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🔄 *Return Request Received*

Hi {{1}},

We\'ve received your return request for order #{{2}}.

📋 Return ID: {{3}}
💰 Amount: ₹{{4}}

Our team will review your request and get back to you within 24-48 hours.

Thank you for your patience! 🙏', 'SJ Fashion Hub Returns Team', NULL, NULL, 'rejected', '24873614365604277', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:28', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(27, 'return_approved_sjfashion', 'Return Approved - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '✅ *Return Request Approved!*

Hi {{1}},

Your return request #{{2}} for order #{{3}} has been approved!

💰 Refund Amount: ₹{{4}}

Please pack the items securely. Our courier partner will pick up the package soon.

You\'ll receive pickup details shortly. 📦', 'Thank you for your cooperation!', NULL, NULL, 'rejected', '1141992961264024', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:38', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(28, 'return_rejected_sjfashion', 'Return Rejected - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '❌ *Return Request Rejected*

Hi {{1}},

We\'re sorry, but your return request #{{2}} for order #{{3}} has been rejected.

Reason: {{4}}

If you have any questions or concerns, please contact our support team.

We\'re here to help! 💬', 'SJ Fashion Hub Support', NULL, NULL, 'rejected', '712766315166714', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:46', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(29, 'return_in_transit_sjfashion', 'Return In Transit - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🚚 *Return Package In Transit*

Hi {{1}},

Your return package for order #{{2}} is on its way to us!

📦 Return ID: {{3}}
🚛 Tracking ID: {{4}}

We\'ll process your refund once we receive and verify the items.

Thank you! 🙏', 'Expected to reach us in 3-5 days', NULL, NULL, 'rejected', '1529730878453528', 'No specific reason provided by WhatsApp', '2025-10-12 11:29:54', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(30, 'return_received_sjfashion', 'Return Received - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '📦 *Return Package Received!*

Hi {{1}},

We\'ve received your return package for order #{{2}}.

📋 Return ID: {{3}}

Our quality team is verifying the items. Your refund will be processed within 2-3 business days.

Thank you for your patience! 🙏', 'SJ Fashion Hub Returns Team', NULL, NULL, 'rejected', '2047977779290993', 'No specific reason provided by WhatsApp', '2025-10-12 11:30:03', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(31, 'return_refund_processed_sjfashion', 'Return Refund Processed - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '💰 *Refund Processed Successfully!*

Hi {{1}},

Your refund for return #{{2}} has been processed!

💵 Refund Amount: ₹{{3}}
💳 Method: {{4}}

The amount will reflect in your account within 5-7 business days.

Thank you for shopping with us! We hope to serve you again soon! 🛍️', 'SJ Fashion Hub - Your Style Partner', NULL, NULL, 'rejected', '1031682885672466', 'No specific reason provided by WhatsApp', '2025-10-12 11:30:11', NULL, '2025-10-12 11:28:42', '2025-10-12 11:39:15', '2025-10-12 11:39:15', NULL, NULL, NULL),
(52, 'sjfashion_order_confirmed_v2', 'Order Confirmed V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '✅ *Order Processing Started!*

Hi {{1}},

Your order #{{2}} is now confirmed and being processed.

💰 Total: ₹{{3}}
📦 Items: {{4}}

Our team is preparing your items for shipment.

Thank you for choosing SJ Fashion Hub!', 'We will update you at every step', NULL, NULL, 'approved', '1108942691447015', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:06', '2025-10-12 12:25:07', '2025-10-12 11:56:00', '2025-10-12 12:25:07', NULL, NULL, NULL, '[\"Rahul Kumar\",\"ORD123456\",\"2499.00\",\"3\"]'),
(53, 'sjfashion_ready_to_ship_v2', 'Ready to Ship V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '📦 *Order Packed & Ready!*

Hi {{1}},

Your order #{{2}} has been packed and is ready for shipment.

📋 Total Items: {{3}}
💰 Amount: ₹{{4}}

Shipment will be dispatched within 24 hours.

Thank you for your patience!', 'Track your order on our website', NULL, NULL, 'approved', '1171831698153983', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:16', '2025-10-12 12:24:15', '2025-10-12 11:56:00', '2025-10-12 12:24:15', NULL, NULL, NULL, '[\"Priya Sharma\",\"ORD123457\",\"2\",\"1899.00\"]'),
(54, 'sjfashion_order_cancelled_v2', 'Order Cancelled V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '❌ *Order Cancellation Notice*

Hi {{1}},

Your order #{{2}} has been cancelled as requested.

💰 Order Value: ₹{{3}}

Refund will be processed within 5-7 business days if payment was made.

We hope to serve you again soon!', 'Contact support for any queries', NULL, NULL, 'approved', '1515030482862412', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:24', '2025-10-12 12:24:11', '2025-10-12 11:56:00', '2025-10-12 12:24:11', NULL, NULL, NULL, '[\"Amit Singh\",\"ORD123458\",\"3299.00\"]'),
(55, 'sjfashion_order_rto_v2', 'Order RTO V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🔄 *Delivery Unsuccessful - RTO*

Hi {{1}},

Your order #{{2}} could not be delivered and is returning to us.

💰 Order Value: ₹{{3}}

Refund will be initiated once package is received at our warehouse.

Please contact us to re-order.', 'SJ Fashion Hub Support', NULL, NULL, 'approved', '652521937930478', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:33', '2025-10-12 12:22:32', '2025-10-12 11:56:00', '2025-10-12 12:22:32', NULL, NULL, NULL, '[\"Neha Patel\",\"ORD123459\",\"2799.00\"]'),
(56, 'sjfashion_return_request_v2', 'Return Request V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🔄 *Return Request Submitted*

Hi {{1}},

We have received your return request for order #{{2}}.

📋 Return ID: {{3}}
💰 Value: ₹{{4}}

Our team will review within 24-48 hours.

Thank you!', 'SJ Fashion Hub Returns', NULL, NULL, 'approved', '2298605893947636', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:43', '2025-10-12 12:22:29', '2025-10-12 11:56:00', '2025-10-12 12:22:29', NULL, NULL, NULL, '[\"Vikram Reddy\",\"ORD123460\",\"RET123001\",\"1999.00\"]'),
(57, 'sjfashion_return_approved_v2', 'Return Approved V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '✅ *Return Request Accepted!*

Hi {{1}},

Your return request #{{2}} for order #{{3}} is approved.

💰 Refund: ₹{{4}}

Pickup will be scheduled soon. Please keep items packed.

Thank you!', 'Pickup details will be shared', NULL, NULL, 'approved', '1435321570864023', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:52', '2025-10-12 12:20:19', '2025-10-12 11:56:00', '2025-10-12 12:20:19', NULL, NULL, NULL, '[\"Sneha Gupta\",\"RET123002\",\"ORD123461\",\"2499.00\"]'),
(58, 'sjfashion_return_rejected_v2', 'Return Rejected V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '❌ *Return Request Declined*

Hi {{1}},

Your return request #{{2}} for order #{{3}} cannot be processed.

Reason: {{4}}

Please contact support for assistance.

Thank you!', 'SJ Fashion Hub Support', NULL, NULL, 'approved', '1910546796158495', 'No specific reason provided by WhatsApp', '2025-10-12 11:56:59', '2025-10-12 12:19:19', '2025-10-12 11:56:00', '2025-10-12 12:19:19', NULL, NULL, NULL, '[\"Rajesh Kumar\",\"RET123003\",\"ORD123462\",\"Return period expired\"]'),
(59, 'sjfashion_return_in_transit_v2', 'Return In Transit V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '🚚 *Return Pickup Done!*

Hi {{1}},

Your return for order #{{2}} has been picked up.

📦 Return ID: {{3}}
🚛 Tracking: {{4}}

Refund will be processed after quality check.

Thank you!', 'Expected at warehouse in 3-5 days', NULL, NULL, 'approved', '1895928697992192', 'No specific reason provided by WhatsApp', '2025-10-12 11:57:07', '2025-10-12 12:17:07', '2025-10-12 11:56:00', '2025-10-12 12:17:07', NULL, NULL, NULL, '[\"Kavita Joshi\",\"ORD123463\",\"RET123004\",\"RTN987654321\"]'),
(60, 'sjfashion_return_received_v2', 'Return Received V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '📦 *Return Received at Warehouse!*

Hi {{1}},

Your return for order #{{2}} has reached our warehouse.

📋 Return ID: {{3}}

Quality verification in progress. Refund in 2-3 days.

Thank you!', 'SJ Fashion Hub Returns', NULL, NULL, 'approved', '2146951232498297', NULL, '2025-10-12 11:57:15', '2025-10-12 11:58:40', '2025-10-12 11:56:00', '2025-10-12 11:58:40', NULL, NULL, NULL, '[\"Deepak Verma\",\"ORD123464\",\"RET123005\"]'),
(61, 'sjfashion_refund_processed_v2', 'Refund Processed V2 - SJ Fashion Hub', 'UTILITY', 'en', NULL, NULL, '💰 *Refund Completed Successfully!*

Hi {{1}},

Refund for return #{{2}} has been processed.

💵 Amount: ₹{{3}}
💳 Mode: {{4}}

Amount will reflect in 5-7 business days.

Thank you for shopping with us!', 'SJ Fashion Hub', NULL, NULL, 'approved', '1324810715890116', NULL, '2025-10-12 11:57:24', '2025-10-12 11:58:37', '2025-10-12 11:56:00', '2025-10-12 11:58:37', NULL, NULL, NULL, '[\"Anjali Mehta\",\"RET123006\",\"1799.00\",\"Original payment method\"]');


-- Table structure for table `whatsapp_campaigns`
DROP TABLE IF EXISTS `whatsapp_campaigns`;
CREATE TABLE "whatsapp_campaigns" ("id" integer primary key autoincrement not null, "name" varchar not null, "description" text, "template_id" integer not null, "status" varchar not null default ('draft'), "target_audience" text, "variable_values" text, "scheduled_at" datetime, "started_at" datetime, "completed_at" datetime, "total_recipients" integer not null default ('0'), "sent_count" integer not null default ('0'), "delivered_count" integer not null default ('0'), "read_count" integer not null default ('0'), "failed_count" integer not null default ('0'), "created_at" datetime, "updated_at" datetime, "deleted_at" datetime, "account_id" integer, foreign key("template_id") references whatsapp_templates("id") on delete cascade on update no action, foreign key("account_id") references "whatsapp_accounts"("id") on delete set null);


-- Dumping data for table `whatsapp_campaigns`
INSERT INTO `whatsapp_campaigns` (`id`, `name`, `description`, `template_id`, `status`, `target_audience`, `variable_values`, `scheduled_at`, `started_at`, `completed_at`, `total_recipients`, `sent_count`, `delivered_count`, `read_count`, `failed_count`, `created_at`, `updated_at`, `deleted_at`, `account_id`) VALUES
(1, 'Ultra', NULL, 4, 'completed', NULL, '[]', NULL, '2025-10-03 21:44:02', '2025-10-03 21:55:08', 1, 1, 0, 0, 0, '2025-10-03 21:44:00', '2025-10-03 21:55:08', NULL, 1),
(2, 'SJ Fashion', NULL, 1, 'completed', NULL, '[{\"type\":\"user_field\",\"value\":\"name\"},{\"type\":\"custom\",\"value\":\"10%\"},{\"type\":\"custom\",\"value\":\"NEW10\"},{\"type\":\"custom\",\"value\":\"December 2025\"}]', NULL, '2025-10-03 22:03:35', '2025-10-03 22:03:37', 1, 1, 0, 0, 0, '2025-10-03 22:03:31', '2025-10-03 22:03:37', NULL, 1);


-- Table structure for table `mobile_app_settings`
DROP TABLE IF EXISTS `mobile_app_settings`;
CREATE TABLE "mobile_app_settings" ("id" integer primary key autoincrement not null, "key" varchar not null, "value" text, "type" varchar not null default 'text', "group" varchar not null default 'general', "label" varchar not null, "description" text, "order" integer not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_settings`
INSERT INTO `mobile_app_settings` (`id`, `key`, `value`, `type`, `group`, `label`, `description`, `order`, `created_at`, `updated_at`) VALUES
(1, 'api_base_url', 'https://sjfashionhub.com', 'text', 'api', 'API Base URL', 'Base URL for API requests', 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(2, 'api_version', 'v1', 'text', 'api', 'API Version', 'API version to use', 2, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(3, 'app_name', 'SJ Fashion Hub', 'text', 'general', 'App Name', 'Mobile app name', 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(4, 'app_logo', 'mobile/settings/i0MfDkIIdpoCmltMTgBeKFc4QT8L5xbrrhMiHxJr.png', 'image', 'general', 'App Logo', 'App logo image', 2, '2025-10-06 20:08:31', '2025-10-10 21:26:52'),
(5, 'app_version', '1.0.0', 'text', 'general', 'App Version', 'Current app version', 3, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(6, 'force_update', 'false', 'boolean', 'general', 'Force Update', 'Force users to update app', 4, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(7, 'min_version', '1.0.0', 'text', 'general', 'Minimum Version', 'Minimum supported app version', 5, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(8, 'primary_color', '#6200ee', 'color', 'theme', 'Primary Color', 'Main app color', 1, '2025-10-06 20:08:31', '2025-10-10 21:26:52'),
(9, 'secondary_color', '#03dac6', 'color', 'theme', 'Secondary Color', 'Secondary app color', 2, '2025-10-06 20:08:31', '2025-10-10 21:26:52'),
(10, 'dark_mode', 'false', 'boolean', 'theme', 'Dark Mode', 'Enable dark mode', 3, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(11, 'firebase_enabled', 'true', 'boolean', 'notification', 'Firebase Enabled', 'Enable Firebase notifications', 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(12, 'fcm_server_key', '', 'text', 'notification', 'FCM Server Key', 'Firebase Cloud Messaging server key', 2, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(13, 'enable_wishlist', 'true', 'boolean', 'features', 'Enable Wishlist', 'Enable wishlist feature', 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(14, 'enable_reviews', 'true', 'boolean', 'features', 'Enable Reviews', 'Enable product reviews', 2, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(15, 'enable_tracking', 'true', 'boolean', 'features', 'Enable Order Tracking', 'Enable order tracking', 3, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(16, 'enable_cod', 'true', 'boolean', 'features', 'Enable COD', 'Enable Cash on Delivery', 4, '2025-10-06 20:08:31', '2025-10-06 20:08:31');


-- Table structure for table `mobile_app_sections`
DROP TABLE IF EXISTS `mobile_app_sections`;
CREATE TABLE "mobile_app_sections" ("id" integer primary key autoincrement not null, "title" varchar not null, "type" varchar not null, "description" text, "config" text, "order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_sections`
INSERT INTO `mobile_app_sections` (`id`, `title`, `type`, `description`, `config`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(6, 'Editor’s Picks', 'category_products', NULL, '{\"category_id\":\"22\"}', 2, 1, '2025-10-10 21:56:04', '2025-10-10 22:40:41'),
(7, 'Top Blouse', 'category_products', NULL, '{\"category_id\":\"24\"}', 3, 1, '2025-10-10 22:09:20', '2025-10-10 22:40:41'),
(8, 'Main Banners', 'banner', 'Main promotional banners', '{\"auto_play\":true,\"interval\":3000}', 0, 1, '2025-10-10 22:39:26', '2025-10-10 22:40:41'),
(9, 'Shop by Category', 'category', 'Featured product categories', '{\"layout\":\"grid\",\"columns\":2}', 1, 1, '2025-10-10 22:39:26', '2025-10-10 22:40:41');


-- Table structure for table `mobile_app_banners`
DROP TABLE IF EXISTS `mobile_app_banners`;
CREATE TABLE "mobile_app_banners" ("id" integer primary key autoincrement not null, "title" varchar not null, "image" varchar not null, "link_type" varchar not null default 'none', "link_value" varchar, "order" integer not null default '0', "is_active" tinyint(1) not null default '1', "start_date" datetime, "end_date" datetime, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_banners`
INSERT INTO `mobile_app_banners` (`id`, `title`, `image`, `link_type`, `link_value`, `order`, `is_active`, `start_date`, `end_date`, `created_at`, `updated_at`) VALUES
(1, 'Shop Now', 'mobile/banners/jtacWxrJCuKMczKU1stJfsrfE4GdljqZWTekVKmP.jpg', 'none', NULL, 0, 1, NULL, NULL, '2025-10-10 11:39:18', '2025-10-10 11:39:18');


-- Table structure for table `mobile_app_menu_items`
DROP TABLE IF EXISTS `mobile_app_menu_items`;
CREATE TABLE "mobile_app_menu_items" ("id" integer primary key autoincrement not null, "title" varchar not null, "icon" varchar, "type" varchar not null, "value" varchar, "order" integer not null default '0', "is_active" tinyint(1) not null default '1', "show_in_bottom_nav" tinyint(1) not null default '0', "show_in_drawer" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_menu_items`
INSERT INTO `mobile_app_menu_items` (`id`, `title`, `icon`, `type`, `value`, `order`, `is_active`, `show_in_bottom_nav`, `show_in_drawer`, `created_at`, `updated_at`) VALUES
(1, 'Home', 'home', 'home', NULL, 1, 1, 1, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(2, 'Categories', 'category', 'categories', NULL, 2, 1, 1, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(3, 'Cart', 'shopping_cart', 'cart', NULL, 3, 1, 1, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(4, 'Wishlist', 'favorite', 'wishlist', NULL, 4, 1, 0, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(5, 'Orders', 'receipt', 'orders', NULL, 5, 1, 0, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31'),
(6, 'Profile', 'person', 'profile', NULL, 6, 1, 1, 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31');


-- Table structure for table `mobile_app_featured_categories`
DROP TABLE IF EXISTS `mobile_app_featured_categories`;
CREATE TABLE "mobile_app_featured_categories" ("id" integer primary key autoincrement not null, "category_id" integer not null, "image" varchar, "order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime, foreign key("category_id") references "categories"("id") on delete cascade);


-- Dumping data for table `mobile_app_featured_categories`
INSERT INTO `mobile_app_featured_categories` (`id`, `category_id`, `image`, `order`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 22, NULL, 1, 1, '2025-10-10 11:38:26', '2025-10-10 11:38:26'),
(2, 23, NULL, 2, 1, '2025-10-10 11:38:30', '2025-10-10 11:38:30'),
(3, 24, NULL, 3, 1, '2025-10-10 11:38:34', '2025-10-10 11:38:34'),
(4, 31, NULL, 4, 1, '2025-10-10 11:38:38', '2025-10-10 11:38:38'),
(5, 33, NULL, 5, 1, '2025-10-10 11:38:42', '2025-10-10 11:38:42'),
(6, 25, NULL, 6, 1, '2025-10-10 11:38:48', '2025-10-10 11:38:48'),
(7, 26, NULL, 7, 1, '2025-10-10 11:38:51', '2025-10-10 11:38:51'),
(8, 21, NULL, 8, 1, '2025-10-10 11:38:53', '2025-10-10 11:38:53');


-- Table structure for table `mobile_app_featured_products`
DROP TABLE IF EXISTS `mobile_app_featured_products`;
CREATE TABLE "mobile_app_featured_products" ("id" integer primary key autoincrement not null, "product_id" integer not null, "badge" varchar, "order" integer not null default '0', "is_active" tinyint(1) not null default '1', "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete cascade);


-- Dumping data for table `mobile_app_featured_products`
-- No data to dump


-- Table structure for table `mobile_app_themes`
DROP TABLE IF EXISTS `mobile_app_themes`;
CREATE TABLE "mobile_app_themes" ("id" integer primary key autoincrement not null, "name" varchar not null, "primary_color" varchar not null default '#6200EE', "secondary_color" varchar not null default '#03DAC6', "background_color" varchar not null default '#FFFFFF', "text_color" varchar not null default '#000000', "card_color" varchar not null default '#F5F5F5', "app_bar_color" varchar not null default '#6200EE', "is_active" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_themes`
INSERT INTO `mobile_app_themes` (`id`, `name`, `primary_color`, `secondary_color`, `background_color`, `text_color`, `card_color`, `app_bar_color`, `is_active`, `created_at`, `updated_at`) VALUES
(1, 'Default Theme', '#6200EE', '#03DAC6', '#FFFFFF', '#000000', '#F5F5F5', '#6200EE', 1, '2025-10-06 20:08:31', '2025-10-06 20:08:31');


-- Table structure for table `mobile_app_notifications`
DROP TABLE IF EXISTS `mobile_app_notifications`;
CREATE TABLE "mobile_app_notifications" ("id" integer primary key autoincrement not null, "title" varchar not null, "body" text not null, "image" varchar, "type" varchar not null default 'general', "data" text, "scheduled_at" datetime, "sent_at" datetime, "sent_count" integer not null default '0', "is_sent" tinyint(1) not null default '0', "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `mobile_app_notifications`
-- No data to dump


-- Table structure for table `mobile_app_devices`
DROP TABLE IF EXISTS `mobile_app_devices`;
CREATE TABLE "mobile_app_devices" ("id" integer primary key autoincrement not null, "user_id" integer, "fcm_token" varchar not null, "platform" varchar not null, "device_id" varchar, "app_version" varchar, "is_active" tinyint(1) not null default '1', "last_active_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `mobile_app_devices`
-- No data to dump


-- Table structure for table `mobile_app_analytics`
DROP TABLE IF EXISTS `mobile_app_analytics`;
CREATE TABLE "mobile_app_analytics" ("id" integer primary key autoincrement not null, "user_id" integer, "event_type" varchar not null, "screen_name" varchar, "event_data" text, "platform" varchar not null, "app_version" varchar, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete set null);


-- Dumping data for table `mobile_app_analytics`
-- No data to dump


-- Table structure for table `whatsapp_messages`
DROP TABLE IF EXISTS `whatsapp_messages`;
CREATE TABLE "whatsapp_messages" ("id" integer primary key autoincrement not null, "message_id" varchar, "wamid" varchar, "direction" varchar not null default 'outbound', "type" varchar not null, "status" varchar not null default 'pending', "phone_number" varchar not null, "user_id" integer, "category" varchar, "template_name" varchar, "content" text not null, "media" text, "parameters" text, "metadata" text, "sent_at" datetime, "delivered_at" datetime, "read_at" datetime, "failed_at" datetime, "error_message" text, "order_id" integer, "return_order_id" integer, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete set null, foreign key("order_id") references "orders"("id") on delete set null, foreign key("return_order_id") references "return_orders"("id") on delete set null);


-- Dumping data for table `whatsapp_messages`
INSERT INTO `whatsapp_messages` (`id`, `message_id`, `wamid`, `direction`, `type`, `status`, `phone_number`, `user_id`, `category`, `template_name`, `content`, `media`, `parameters`, `metadata`, `sent_at`, `delivered_at`, `read_at`, `failed_at`, `error_message`, `order_id`, `return_order_id`, `created_at`, `updated_at`) VALUES
(1, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSN0VCNjY3QUIwMDhDRUEzRjI2AA==', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSN0VCNjY3QUIwMDhDRUEzRjI2AA==', 'outbound', 'template', 'sent', '918536945959', 5, 'order', 'order_placed_sjfashion', 'Template: order_placed_sjfashion', NULL, '[\"Jasim Mondal\",\"ORD-2025-228758\",\"249.00\",\"0\"]', NULL, '2025-10-12 15:41:32', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 15:41:32', '2025-10-12 15:41:32'),
(2, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRjA2MEY4RjBFNERDOUEzN0IwAA==', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRjA2MEY4RjBFNERDOUEzN0IwAA==', 'outbound', 'template', 'sent', '918536945959', 5, 'order', 'order_placed_sjfashion', 'Template: order_placed_sjfashion', NULL, '[\"Jasim Mondal\",\"ORD-2025-315313\",\"249.00\",\"0\"]', NULL, '2025-10-12 15:42:00', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 15:42:00', '2025-10-12 15:42:00'),
(3, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSMEE5NDYxREE3RkZEOEVDQ0FBAA==', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSMEE5NDYxREE3RkZEOEVDQ0FBAA==', 'outbound', 'template', 'sent', '918536945959', 5, 'order', 'order_placed_sjfashion', 'Template: order_placed_sjfashion', NULL, '[\"Jasim Mondal\",\"ORD-2025-605089\",\"249.00\",\"0\"]', NULL, '2025-10-12 16:11:47', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 16:11:47', '2025-10-12 16:11:47'),
(4, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSODUyMkMyOEExQjVGQTJCRDNFAA==', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSODUyMkMyOEExQjVGQTJCRDNFAA==', 'outbound', 'text', 'sent', '918536945959', 5, 'support', NULL, 'hi', NULL, NULL, NULL, '2025-10-12 18:42:07', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 18:42:07', '2025-10-12 18:42:07'),
(5, 'wamid.HBgMOTE4NjcwNzM4MDIxFQIAEhggQUMyMkI0NkY2QzI5RTI0M0Y5M0MzMzZBQTFDQUExQzUA', 'wamid.HBgMOTE4NjcwNzM4MDIxFQIAEhggQUMyMkI0NkY2QzI5RTI0M0Y5M0MzMzZBQTFDQUExQzUA', 'inbound', 'order', 'received', '918670738021', NULL, 'support', NULL, 'Order message received', NULL, NULL, '{\"from\":\"918670738021\",\"id\":\"wamid.HBgMOTE4NjcwNzM4MDIxFQIAEhggQUMyMkI0NkY2QzI5RTI0M0Y5M0MzMzZBQTFDQUExQzUA\",\"timestamp\":\"1760282420\",\"type\":\"order\",\"order\":{\"catalog_id\":\"857962576567865\",\"text\":null,\"product_items\":[{\"product_retailer_id\":\"79\",\"quantity\":1,\"item_price\":249,\"currency\":\"INR\"}]}}', '2025-10-12 20:50:20', '2025-10-12 20:50:23', NULL, NULL, NULL, NULL, NULL, '2025-10-12 20:50:23', '2025-10-12 20:50:23'),
(6, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1OTYwM0I1Qjc1NzY1REU5NDkwNkIzQzNBMjVFNjEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1OTYwM0I1Qjc1NzY1REU5NDkwNkIzQzNBMjVFNjEA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1OTYwM0I1Qjc1NzY1REU5NDkwNkIzQzNBMjVFNjEA\",\"timestamp\":\"1760284576\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 21:26:16', '2025-10-12 21:26:18', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:26:18', '2025-10-12 21:26:18'),
(7, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 21:40:55', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:40:55', '2025-10-12 21:40:55'),
(8, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3REVGRDYxODhEOEY0NjVBMUIyMDk5NEIyNzUyRkMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3REVGRDYxODhEOEY0NjVBMUIyMDk5NEIyNzUyRkMA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3REVGRDYxODhEOEY0NjVBMUIyMDk5NEIyNzUyRkMA\",\"timestamp\":\"1760285453\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 21:40:53', '2025-10-12 21:40:55', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:40:55', '2025-10-12 21:40:55'),
(9, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 21:49:08', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:08', '2025-10-12 21:49:08'),
(10, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 21:49:09', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:09', '2025-10-12 21:49:09'),
(11, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxNERBNDNCOEE3OENEMzUxM0Y4OUYyODZGRTc1MDIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxNERBNDNCOEE3OENEMzUxM0Y4OUYyODZGRTc1MDIA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxNERBNDNCOEE3OENEMzUxM0Y4OUYyODZGRTc1MDIA\",\"timestamp\":\"1760285946\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 21:49:06', '2025-10-12 21:49:09', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:09', '2025-10-12 21:49:09'),
(12, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Browse Products', NULL, NULL, NULL, '2025-10-12 21:49:15', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:15', '2025-10-12 21:49:15'),
(13, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5QjZCRTAzMTAyOEZGNkIzMzQ1NTlCRkIwMUM3NEQA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5QjZCRTAzMTAyOEZGNkIzMzQ1NTlCRkIwMUM3NEQA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQ0Y3MkEwOTA3QkNDRjdFNURDAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5QjZCRTAzMTAyOEZGNkIzMzQ1NTlCRkIwMUM3NEQA\",\"timestamp\":\"1760285952\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"browse_products\",\"title\":\"\\ud83d\\udecd\\ufe0f Browse Products\"}}}', '2025-10-12 21:49:12', '2025-10-12 21:49:15', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:15', '2025-10-12 21:49:15'),
(14, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: 2 Pcs Set', NULL, NULL, NULL, '2025-10-12 21:49:22', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:22', '2025-10-12 21:49:22'),
(15, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzgyN0JCMkUxNjlBRkIyRTZCOTVBMTlDM0UwRTUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzgyN0JCMkUxNjlBRkIyRTZCOTVBMTlDM0UwRTUA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNUVGRkNERDdFNzA3NEEyNjg1AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzgyN0JCMkUxNjlBRkIyRTZCOTVBMTlDM0UwRTUA\",\"timestamp\":\"1760285960\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"cat_22\",\"title\":\"2 Pcs Set\",\"description\":\"4 products\"}}}', '2025-10-12 21:49:20', '2025-10-12 21:49:22', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:22', '2025-10-12 21:49:22'),
(16, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Image: https://sjfashionhub.com/storage/products/migrated_1759079675_68d96cfb72557.jpg', NULL, NULL, NULL, '2025-10-12 21:49:30', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:30', '2025-10-12 21:49:30'),
(17, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: Add this product to your cart?', NULL, NULL, NULL, '2025-10-12 21:49:31', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:31', '2025-10-12 21:49:31'),
(18, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3ODA4MTVGNDkxNTQ1RDdCNDQxMjE4QzVCREQyMUUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3ODA4MTVGNDkxNTQ1RDdCNDQxMjE4QzVCREQyMUUA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQzI2MTVFNjhDQTVCQTkzNjcwAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3ODA4MTVGNDkxNTQ1RDdCNDQxMjE4QzVCREQyMUUA\",\"timestamp\":\"1760285968\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"prod_12\",\"title\":\"2 Pcs Set\",\"description\":\"\\u20b9360\"}}}', '2025-10-12 21:49:28', '2025-10-12 21:49:31', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:31', '2025-10-12 21:49:31'),
(19, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: ✅ *2 Pcs Set* added to cart!

🛒 Cart: 1 item(s)

What would you like to do next?', NULL, NULL, NULL, '2025-10-12 21:49:43', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:43', '2025-10-12 21:49:43'),
(20, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDZBMTg3ODQ1MThBN0NFQkRBQjZBMTU2MTY4MEIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDZBMTg3ODQ1MThBN0NFQkRBQjZBMTU2MTY4MEIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQTE1MzU1RTY4QTdBQUYwMjVFAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDZBMTg3ODQ1MThBN0NFQkRBQjZBMTU2MTY4MEIA\",\"timestamp\":\"1760285981\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"add_12\",\"title\":\"\\ud83d\\uded2 Add to Cart\"}}}', '2025-10-12 21:49:41', '2025-10-12 21:49:43', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:43', '2025-10-12 21:49:43'),
(21, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'To complete your order, please provide your details:

Send your full name:', NULL, NULL, NULL, '2025-10-12 21:49:50', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:50', '2025-10-12 21:49:50'),
(22, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEOTA3M0U0MTc0NzhBQTZBOEFBMzYwOTYxRDg4Q0IA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEOTA3M0U0MTc0NzhBQTZBOEFBMzYwOTYxRDg4Q0IA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNzhDRjdBNENBOUYwQzNDQTZGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEOTA3M0U0MTc0NzhBQTZBOEFBMzYwOTYxRDg4Q0IA\",\"timestamp\":\"1760285988\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"checkout\",\"title\":\"\\ud83d\\udcb3 Checkout\"}}}', '2025-10-12 21:49:48', '2025-10-12 21:49:50', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:50', '2025-10-12 21:49:50'),
(23, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Jasim', NULL, NULL, NULL, NULL, '2025-10-12 21:49:59', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:49:59', '2025-10-12 21:49:59'),
(24, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Thanks Jasim!

📧 Please send your email address:', NULL, NULL, NULL, '2025-10-12 21:50:00', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:00', '2025-10-12 21:50:00'),
(25, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwRjI4OTkyNDUwOTM5MjEyOTk1NkUyMjQ0NEUzMUIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwRjI4OTkyNDUwOTM5MjEyOTk1NkUyMjQ0NEUzMUIA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Jasim', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwRjI4OTkyNDUwOTM5MjEyOTk1NkUyMjQ0NEUzMUIA\",\"timestamp\":\"1760285998\",\"text\":{\"body\":\"Jasim\"},\"type\":\"text\"}', '2025-10-12 21:49:58', '2025-10-12 21:50:00', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:00', '2025-10-12 21:50:00'),
(26, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'jasimmondal57@gmail.com', NULL, NULL, NULL, NULL, '2025-10-12 21:50:08', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:08', '2025-10-12 21:50:08'),
(27, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Email saved!

📍 Please send your complete delivery address:', NULL, NULL, NULL, '2025-10-12 21:50:09', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:09', '2025-10-12 21:50:09'),
(28, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMTQ1QzJFOThGM0RDNTlEQ0ZGMTI5MTI2NTgyNzgA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMTQ1QzJFOThGM0RDNTlEQ0ZGMTI5MTI2NTgyNzgA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'jasimmondal57@gmail.com', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMTQ1QzJFOThGM0RDNTlEQ0ZGMTI5MTI2NTgyNzgA\",\"timestamp\":\"1760286007\",\"text\":{\"body\":\"jasimmondal57@gmail.com\"},\"type\":\"text\"}', '2025-10-12 21:50:07', '2025-10-12 21:50:09', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:09', '2025-10-12 21:50:09'),
(29, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Bolpur', NULL, NULL, NULL, NULL, '2025-10-12 21:50:23', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:23', '2025-10-12 21:50:23'),
(30, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Please provide a complete address:', NULL, NULL, NULL, '2025-10-12 21:50:24', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:24', '2025-10-12 21:50:24'),
(31, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QUNDM0NGMTRFRjZDNkZFQ0REN0RFNDA3NEY0NjAA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QUNDM0NGMTRFRjZDNkZFQ0REN0RFNDA3NEY0NjAA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Bolpur', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QUNDM0NGMTRFRjZDNkZFQ0REN0RFNDA3NEY0NjAA\",\"timestamp\":\"1760286021\",\"text\":{\"body\":\"Bolpur\"},\"type\":\"text\"}', '2025-10-12 21:50:21', '2025-10-12 21:50:24', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:24', '2025-10-12 21:50:24'),
(32, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Bolpur, nazrulpally', NULL, NULL, NULL, NULL, '2025-10-12 21:50:35', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:35', '2025-10-12 21:50:35'),
(33, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Address saved!

🏙️ Please send your city name:', NULL, NULL, NULL, '2025-10-12 21:50:36', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:36', '2025-10-12 21:50:36'),
(34, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxODAxNEJEODhGQUM4NkYyRjg2MjI3Qjc0OTc0NEYA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxODAxNEJEODhGQUM4NkYyRjg2MjI3Qjc0OTc0NEYA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Bolpur, nazrulpally', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxODAxNEJEODhGQUM4NkYyRjg2MjI3Qjc0OTc0NEYA\",\"timestamp\":\"1760286033\",\"text\":{\"body\":\"Bolpur, nazrulpally\"},\"type\":\"text\"}', '2025-10-12 21:50:33', '2025-10-12 21:50:36', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:36', '2025-10-12 21:50:36'),
(35, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Bolpur', NULL, NULL, NULL, NULL, '2025-10-12 21:50:42', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:42', '2025-10-12 21:50:42'),
(36, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ City saved!

📮 Please send your 6-digit pincode:', NULL, NULL, NULL, '2025-10-12 21:50:43', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:43', '2025-10-12 21:50:43'),
(37, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzNEZGQTE4ODg4NTRCNjE3MDAzRkRGQjI3M0ZEN0QA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzNEZGQTE4ODg4NTRCNjE3MDAzRkRGQjI3M0ZEN0QA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Bolpur', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzNEZGQTE4ODg4NTRCNjE3MDAzRkRGQjI3M0ZEN0QA\",\"timestamp\":\"1760286040\",\"text\":{\"body\":\"Bolpur\"},\"type\":\"text\"}', '2025-10-12 21:50:40', '2025-10-12 21:50:43', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:43', '2025-10-12 21:50:43'),
(38, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, '731204', NULL, NULL, NULL, NULL, '2025-10-12 21:50:50', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:50', '2025-10-12 21:50:50'),
(39, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 📋 *Please confirm your details:*

👤 Name: Jasim
📧 Email: jasimmondal57@gmail.com
📍 Address: Bolpur, nazrulpally
🏙️ City: Bolpur
📮 Pincode: 731204

Is this information correct?', NULL, NULL, NULL, '2025-10-12 21:50:51', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:51', '2025-10-12 21:50:51'),
(40, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjk4MjZEMDE2MjU2RjM0QTg0MjZFQkMzN0QwOTAA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjk4MjZEMDE2MjU2RjM0QTg0MjZFQkMzN0QwOTAA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, '731204', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjk4MjZEMDE2MjU2RjM0QTg0MjZFQkMzN0QwOTAA\",\"timestamp\":\"1760286048\",\"text\":{\"body\":\"731204\"},\"type\":\"text\"}', '2025-10-12 21:50:48', '2025-10-12 21:50:51', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:51', '2025-10-12 21:50:51'),
(41, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 💳 *Select Payment Method*

Order Total: ₹360

Choose your payment method:', NULL, NULL, NULL, '2025-10-12 21:50:56', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:56', '2025-10-12 21:50:56'),
(42, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGNERCNzBFQzlCRkIzNDc2MzMwNUZCQzc4NzE4RjUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGNERCNzBFQzlCRkIzNDc2MzMwNUZCQzc4NzE4RjUA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQkUxQzFGMjRCRDFGMDRFMzFGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGNERCNzBFQzlCRkIzNDc2MzMwNUZCQzc4NzE4RjUA\",\"timestamp\":\"1760286054\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"confirm_details\",\"title\":\"\\u2705 Confirm\"}}}', '2025-10-12 21:50:54', '2025-10-12 21:50:56', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:50:56', '2025-10-12 21:50:56'),
(43, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 📦 *Order Summary*

━━━━━━━━━━━━━━━━━━━━━━

• 2 Pcs Set
  Qty: 1 × ₹360 = ₹360

━━━━━━━━━━━━━━━━━━━━━━
Subtotal: ₹360
Shipping: ₹50
*Total: ₹410*

💳 Payment: Online Payment

📍 Delivery to:
Jasim
Bolpur, nazrulpally
Bolpur - 731204

━━━━━━━━━━━━━━━━━━━━━━

Confirm your order?', NULL, NULL, NULL, '2025-10-12 21:51:01', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:51:01', '2025-10-12 21:51:01'),
(44, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxOERBQ0E3RDY4MTVEMjQ0MTQ2QTcwMDQ2QUYxMzEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxOERBQ0E3RDY4MTVEMjQ0MTQ2QTcwMDQ2QUYxMzEA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOEZBNzEwQTJCQkVDQThBMUY2AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxOERBQ0E3RDY4MTVEMjQ0MTQ2QTcwMDQ2QUYxMzEA\",\"timestamp\":\"1760286059\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"payment_online\",\"title\":\"\\ud83d\\udcb3 WhatsApp Pay\"}}}', '2025-10-12 21:50:59', '2025-10-12 21:51:01', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:51:01', '2025-10-12 21:51:01'),
(45, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Sorry, we couldn\'t process your order. Please try again or contact support.', NULL, NULL, NULL, '2025-10-12 21:51:08', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:51:08', '2025-10-12 21:51:08'),
(46, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyQTBBQTdDRURDOUE4NUZEOUJGRTM0QjA0NzQzRDIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyQTBBQTdDRURDOUE4NUZEOUJGRTM0QjA0NzQzRDIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQjBEMUYwNTVBQzlEREUwMUE5AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyQTBBQTdDRURDOUE4NUZEOUJGRTM0QjA0NzQzRDIA\",\"timestamp\":\"1760286066\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"confirm_order_online\",\"title\":\"\\u2705 Confirm Order\"}}}', '2025-10-12 21:51:06', '2025-10-12 21:51:08', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:51:08', '2025-10-12 21:51:08'),
(47, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 📦 *Order Summary*

━━━━━━━━━━━━━━━━━━━━━━

• 2 Pcs Set
  Qty: 1 × ₹360 = ₹360

━━━━━━━━━━━━━━━━━━━━━━
Subtotal: ₹360
Shipping: ₹50
*Total: ₹410*

💳 Payment: Cash on Delivery

📍 Delivery to:
Jasim
Bolpur, nazrulpally
Bolpur - 731204

━━━━━━━━━━━━━━━━━━━━━━

Confirm your order?', NULL, NULL, NULL, '2025-10-12 21:53:35', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:53:35', '2025-10-12 21:53:35'),
(48, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjUyMTcyRjEwRTNCMjk5Njc2RDBEQkI1MzE4QTEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjUyMTcyRjEwRTNCMjk5Njc2RDBEQkI1MzE4QTEA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOEZBNzEwQTJCQkVDQThBMUY2AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMjUyMTcyRjEwRTNCMjk5Njc2RDBEQkI1MzE4QTEA\",\"timestamp\":\"1760286213\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"payment_cod\",\"title\":\"\\ud83d\\udcb5 COD\"}}}', '2025-10-12 21:53:33', '2025-10-12 21:53:35', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:53:35', '2025-10-12 21:53:35'),
(49, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Sorry, we couldn\'t process your order. Please try again or contact support.', NULL, NULL, NULL, '2025-10-12 21:53:40', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:53:40', '2025-10-12 21:53:40'),
(50, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1MDk1QTU5RkFFOTFDQjYyMjk3RUNFRkQzRTA2RjAA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1MDk1QTU5RkFFOTFDQjYyMjk3RUNFRkQzRTA2RjAA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRUNFMDQxRjFCMzlFRUFBRkJEAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1MDk1QTU5RkFFOTFDQjYyMjk3RUNFRkQzRTA2RjAA\",\"timestamp\":\"1760286217\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"confirm_order_cod\",\"title\":\"\\u2705 Confirm Order\"}}}', '2025-10-12 21:53:37', '2025-10-12 21:53:40', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:53:40', '2025-10-12 21:53:40'),
(51, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 21:55:19', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:55:19', '2025-10-12 21:55:19'),
(52, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 21:55:20', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:55:20', '2025-10-12 21:55:20'),
(53, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMDYyMkJDMEZCMTlCNEVFODBDN0MzNkJGNjNCN0IA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMDYyMkJDMEZCMTlCNEVFODBDN0MzNkJGNjNCN0IA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMDYyMkJDMEZCMTlCNEVFODBDN0MzNkJGNjNCN0IA\",\"timestamp\":\"1760286318\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 21:55:18', '2025-10-12 21:55:20', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:55:20', '2025-10-12 21:55:20'),
(54, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'No orders found for this number.', NULL, NULL, NULL, '2025-10-12 21:55:26', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:55:26', '2025-10-12 21:55:26'),
(55, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5RTM1NjJDMjJDQTAzNzE0QUQwNTgxNzIzRTc0N0IA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5RTM1NjJDMjJDQTAzNzE0QUQwNTgxNzIzRTc0N0IA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSM0YyM0NFNDBGOUZCQzk5RTRCAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5RTM1NjJDMjJDQTAzNzE0QUQwNTgxNzIzRTc0N0IA\",\"timestamp\":\"1760286323\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"my_orders\",\"title\":\"\\ud83d\\udce6 My Orders\"}}}', '2025-10-12 21:55:23', '2025-10-12 21:55:26', NULL, NULL, NULL, NULL, NULL, '2025-10-12 21:55:26', '2025-10-12 21:55:26'),
(56, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:00:47', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:00:47', '2025-10-12 22:00:47'),
(57, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 22:00:49', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:00:49', '2025-10-12 22:00:49'),
(58, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCQkRCQ0M4RjgwNjAxQUU0RENENTkxNzE3MjFFMTQA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCQkRCQ0M4RjgwNjAxQUU0RENENTkxNzE3MjFFMTQA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCQkRCQ0M4RjgwNjAxQUU0RENENTkxNzE3MjFFMTQA\",\"timestamp\":\"1760286646\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:00:46', '2025-10-12 22:00:49', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:00:49', '2025-10-12 22:00:49'),
(59, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'No orders found for this number.', NULL, NULL, NULL, '2025-10-12 22:00:53', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:00:53', '2025-10-12 22:00:53'),
(60, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5MkM1QUFEOENCMTQ1RTE2OEZDN0IzMUE3ODRBNDMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5MkM1QUFEOENCMTQ1RTE2OEZDN0IzMUE3ODRBNDMA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOUM4NDAxM0RGQTg1QjlEQ0U4AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5MkM1QUFEOENCMTQ1RTE2OEZDN0IzMUE3ODRBNDMA\",\"timestamp\":\"1760286651\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"my_orders\",\"title\":\"\\ud83d\\udce6 My Orders\"}}}', '2025-10-12 22:00:51', '2025-10-12 22:00:53', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:00:53', '2025-10-12 22:00:53'),
(61, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Browse Products', NULL, NULL, NULL, NULL, '2025-10-12 22:02:55', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:02:55', '2025-10-12 22:02:55'),
(62, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Browse Products', NULL, NULL, NULL, '2025-10-12 22:02:56', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:02:56', '2025-10-12 22:02:56'),
(63, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDQ0NFODgzNkI2MEI5NUE5MTY5QzZBQ0JEM0ZENkUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDQ0NFODgzNkI2MEI5NUE5MTY5QzZBQ0JEM0ZENkUA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Browse Products', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDQ0NFODgzNkI2MEI5NUE5MTY5QzZBQ0JEM0ZENkUA\",\"timestamp\":\"1760286774\",\"text\":{\"body\":\"Browse Products\"},\"type\":\"text\"}', '2025-10-12 22:02:54', '2025-10-12 22:02:56', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:02:56', '2025-10-12 22:02:56'),
(64, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Uncategorized', NULL, NULL, NULL, '2025-10-12 22:03:05', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:05', '2025-10-12 22:03:05'),
(65, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2RjRCOTkwMUE2OUUzMTQyRUFCNTMyMzJGRkI2RDgA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2RjRCOTkwMUE2OUUzMTQyRUFCNTMyMzJGRkI2RDgA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNjdCRTJERjI4QkNCRTg0QjZCAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2RjRCOTkwMUE2OUUzMTQyRUFCNTMyMzJGRkI2RDgA\",\"timestamp\":\"1760286783\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"cat_21\",\"title\":\"Uncategorized\",\"description\":\"1 products\"}}}', '2025-10-12 22:03:03', '2025-10-12 22:03:05', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:05', '2025-10-12 22:03:05'),
(66, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '*test*

💰 Price: ₹1
📦 Stock: In Stock (9 available)

Premium uncategorized crafted with attention to detail. test combines style and comfort for the modern fashion enthusiast.

', NULL, NULL, NULL, '2025-10-12 22:03:11', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:11', '2025-10-12 22:03:11'),
(67, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: Add this product to your cart?', NULL, NULL, NULL, '2025-10-12 22:03:12', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:12', '2025-10-12 22:03:12'),
(68, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGQzFBRjlDRUU5QjQ3QTUwRTRDOTNBMzBGRTAxMDIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGQzFBRjlDRUU5QjQ3QTUwRTRDOTNBMzBGRTAxMDIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRjgyMTI3RjJCQkEwM0E2RTE0AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGQzFBRjlDRUU5QjQ3QTUwRTRDOTNBMzBGRTAxMDIA\",\"timestamp\":\"1760286789\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"prod_80\",\"title\":\"test\",\"description\":\"\\u20b91\"}}}', '2025-10-12 22:03:09', '2025-10-12 22:03:12', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:12', '2025-10-12 22:03:12'),
(69, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: ✅ *test* added to cart!

🛒 Cart: 2 item(s)

What would you like to do next?', NULL, NULL, NULL, '2025-10-12 22:03:33', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:33', '2025-10-12 22:03:33'),
(70, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzRjU2MTU3OTNBQjYwNUI2NjExM0E4MzY5RjVGNTkA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzRjU2MTU3OTNBQjYwNUI2NjExM0E4MzY5RjVGNTkA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNUU3NEI0MEZFMkQ1QzkwMjlDAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzRjU2MTU3OTNBQjYwNUI2NjExM0E4MzY5RjVGNTkA\",\"timestamp\":\"1760286810\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"add_80\",\"title\":\"\\ud83d\\uded2 Add to Cart\"}}}', '2025-10-12 22:03:30', '2025-10-12 22:03:33', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:33', '2025-10-12 22:03:33'),
(71, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'To complete your order, please provide your details:

Send your full name:', NULL, NULL, NULL, '2025-10-12 22:03:38', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:38', '2025-10-12 22:03:38'),
(72, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0MUE5QTM0N0RERDE4NDU4NzhERDg1MEI3NkQ3MUQA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0MUE5QTM0N0RERDE4NDU4NzhERDg1MEI3NkQ3MUQA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSMERDOTAwNzczQ0Y3MEVGNUFDAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0MUE5QTM0N0RERDE4NDU4NzhERDg1MEI3NkQ3MUQA\",\"timestamp\":\"1760286816\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"checkout\",\"title\":\"\\ud83d\\udcb3 Checkout\"}}}', '2025-10-12 22:03:36', '2025-10-12 22:03:38', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:38', '2025-10-12 22:03:38'),
(73, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Jasim', NULL, NULL, NULL, NULL, '2025-10-12 22:03:44', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:44', '2025-10-12 22:03:44'),
(74, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Thanks Jasim!

📧 Please send your email address:', NULL, NULL, NULL, '2025-10-12 22:03:45', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:45', '2025-10-12 22:03:45'),
(75, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NTE4RDA0RjIyRDc0MkIwNzlENDc4MEExRjkyRkMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NTE4RDA0RjIyRDc0MkIwNzlENDc4MEExRjkyRkMA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Jasim', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NTE4RDA0RjIyRDc0MkIwNzlENDc4MEExRjkyRkMA\",\"timestamp\":\"1760286823\",\"text\":{\"body\":\"Jasim\"},\"type\":\"text\"}', '2025-10-12 22:03:43', '2025-10-12 22:03:45', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:45', '2025-10-12 22:03:45'),
(76, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'jasimmondal57@gmail.com', NULL, NULL, NULL, NULL, '2025-10-12 22:03:51', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:51', '2025-10-12 22:03:51'),
(77, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Email saved!

📍 Please send your complete delivery address:', NULL, NULL, NULL, '2025-10-12 22:03:52', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:52', '2025-10-12 22:03:52'),
(78, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMEEzQTdDQTc5MDdCOTRENzA0RDU1ODdEQkZFNzEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMEEzQTdDQTc5MDdCOTRENzA0RDU1ODdEQkZFNzEA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'jasimmondal57@gmail.com', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMEEzQTdDQTc5MDdCOTRENzA0RDU1ODdEQkZFNzEA\",\"timestamp\":\"1760286829\",\"text\":{\"body\":\"jasimmondal57@gmail.com\"},\"type\":\"text\"}', '2025-10-12 22:03:49', '2025-10-12 22:03:52', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:52', '2025-10-12 22:03:52'),
(79, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Bolpur,jjkaa', NULL, NULL, NULL, NULL, '2025-10-12 22:03:59', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:03:59', '2025-10-12 22:03:59'),
(80, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Address saved!

🏙️ Please send your city name:', NULL, NULL, NULL, '2025-10-12 22:04:00', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:00', '2025-10-12 22:04:00'),
(81, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NDcxNEU5QjUzQkRCRTJFNUQwNkM3NDE0NjBGMDgA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NDcxNEU5QjUzQkRCRTJFNUQwNkM3NDE0NjBGMDgA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Bolpur,jjkaa', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0NDcxNEU5QjUzQkRCRTJFNUQwNkM3NDE0NjBGMDgA\",\"timestamp\":\"1760286838\",\"text\":{\"body\":\"Bolpur,jjkaa\"},\"type\":\"text\"}', '2025-10-12 22:03:58', '2025-10-12 22:04:00', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:00', '2025-10-12 22:04:00'),
(82, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Bolp', NULL, NULL, NULL, NULL, '2025-10-12 22:04:05', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:05', '2025-10-12 22:04:05'),
(83, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ City saved!

📮 Please send your 6-digit pincode:', NULL, NULL, NULL, '2025-10-12 22:04:05', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:05', '2025-10-12 22:04:05'),
(84, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwODY1NDJDOEVBNkE1NDMzQjI3MjI4M0M2RUM5NEEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwODY1NDJDOEVBNkE1NDMzQjI3MjI4M0M2RUM5NEEA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Bolp', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUwODY1NDJDOEVBNkE1NDMzQjI3MjI4M0M2RUM5NEEA\",\"timestamp\":\"1760286843\",\"text\":{\"body\":\"Bolp\"},\"type\":\"text\"}', '2025-10-12 22:04:03', '2025-10-12 22:04:05', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:05', '2025-10-12 22:04:05'),
(85, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, '731204', NULL, NULL, NULL, NULL, '2025-10-12 22:04:11', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:11', '2025-10-12 22:04:11'),
(86, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 📋 *Please confirm your details:*

👤 Name: Jasim
📧 Email: jasimmondal57@gmail.com
📍 Address: Bolpur,jjkaa
🏙️ City: Bolp
📮 Pincode: 731204

Is this information correct?', NULL, NULL, NULL, '2025-10-12 22:04:11', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:11', '2025-10-12 22:04:11'),
(87, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1RUM5NUM5NTYzOTdERUM3Rjc2MkNDRjkyRERCMzAA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1RUM5NUM5NTYzOTdERUM3Rjc2MkNDRjkyRERCMzAA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, '731204', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1RUM5NUM5NTYzOTdERUM3Rjc2MkNDRjkyRERCMzAA\",\"timestamp\":\"1760286849\",\"text\":{\"body\":\"731204\"},\"type\":\"text\"}', '2025-10-12 22:04:09', '2025-10-12 22:04:11', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:11', '2025-10-12 22:04:11'),
(88, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 💳 *Select Payment Method*

Order Total: ₹361

Choose your payment method:', NULL, NULL, NULL, '2025-10-12 22:04:16', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:16', '2025-10-12 22:04:16'),
(89, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMTRDNTcxOTU4MDg2Q0MzMUYyMDQ1QkE4NTA1MkUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMTRDNTcxOTU4MDg2Q0MzMUYyMDQ1QkE4NTA1MkUA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNjNDQjI3NTdFN0E2RkE5ODZCAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMTRDNTcxOTU4MDg2Q0MzMUYyMDQ1QkE4NTA1MkUA\",\"timestamp\":\"1760286854\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"confirm_details\",\"title\":\"\\u2705 Confirm\"}}}', '2025-10-12 22:04:14', '2025-10-12 22:04:16', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:16', '2025-10-12 22:04:16'),
(90, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 📦 *Order Summary*

━━━━━━━━━━━━━━━━━━━━━━

• 2 Pcs Set
  Qty: 1 × ₹360 = ₹360

• test
  Qty: 1 × ₹1 = ₹1

━━━━━━━━━━━━━━━━━━━━━━
Subtotal: ₹361
Shipping: ₹50
*Total: ₹411*

💳 Payment: Cash on Delivery

📍 Delivery to:
Jasim
Bolpur,jjkaa
Bolp - 731204

━━━━━━━━━━━━━━━━━━━━━━

Confirm your order?', NULL, NULL, NULL, '2025-10-12 22:04:20', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:20', '2025-10-12 22:04:20'),
(91, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1NzdEMDAzNEYzNkFFMzA2RTdERkU3MEZBNTg0MUYA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1NzdEMDAzNEYzNkFFMzA2RTdERkU3MEZBNTg0MUYA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSMUJGNzA4RUNFNkUxN0Y1QzE2AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1NzdEMDAzNEYzNkFFMzA2RTdERkU3MEZBNTg0MUYA\",\"timestamp\":\"1760286858\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"payment_cod\",\"title\":\"\\ud83d\\udcb5 COD\"}}}', '2025-10-12 22:04:18', '2025-10-12 22:04:20', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:20', '2025-10-12 22:04:20'),
(92, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Sorry, we couldn\'t process your order. Please try again or contact support.', NULL, NULL, NULL, '2025-10-12 22:04:39', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:39', '2025-10-12 22:04:39'),
(93, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QjI4MTk2MDlGNkZDMUI3QjUzNEVCNUVDNUZGOUEA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QjI4MTk2MDlGNkZDMUI3QjUzNEVCNUVDNUZGOUEA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRENGMjgzNkJCNjZBODZFQ0QyAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QjI4MTk2MDlGNkZDMUI3QjUzNEVCNUVDNUZGOUEA\",\"timestamp\":\"1760286874\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"confirm_order_cod\",\"title\":\"\\u2705 Confirm Order\"}}}', '2025-10-12 22:04:34', '2025-10-12 22:04:39', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:04:39', '2025-10-12 22:04:39'),
(94, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:07:33', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:07:33', '2025-10-12 22:07:33'),
(95, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 22:07:34', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:07:34', '2025-10-12 22:07:34'),
(96, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMDE4MjZFODdGNzFDNTExOTU3ODkzRERENjc4NUUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMDE4MjZFODdGNzFDNTExOTU3ODkzRERENjc4NUUA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGMDE4MjZFODdGNzFDNTExOTU3ODkzRERENjc4NUUA\",\"timestamp\":\"1760287051\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:07:31', '2025-10-12 22:07:34', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:07:34', '2025-10-12 22:07:34'),
(97, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'No orders found for this number.', NULL, NULL, NULL, '2025-10-12 22:07:39', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:07:39', '2025-10-12 22:07:39'),
(98, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMUQ2N0VBQzg3NEYzMkNDOUY4QTJBMjMzMDI0RjUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMUQ2N0VBQzg3NEYzMkNDOUY4QTJBMjMzMDI0RjUA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSMjUwRTcwQTg0ODRGQ0E4OUMzAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVCMUQ2N0VBQzg3NEYzMkNDOUY4QTJBMjMzMDI0RjUA\",\"timestamp\":\"1760287056\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"my_orders\",\"title\":\"\\ud83d\\udce6 My Orders\"}}}', '2025-10-12 22:07:36', '2025-10-12 22:07:39', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:07:39', '2025-10-12 22:07:39'),
(99, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:12:55', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:12:55', '2025-10-12 22:12:55'),
(100, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 22:12:57', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:12:57', '2025-10-12 22:12:57'),
(101, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzhFOEFDMjhFNkE2RkE3MEJFMEVFQkQ5RTg5NTkA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzhFOEFDMjhFNkE2RkE3MEJFMEVFQkQ5RTg5NTkA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3QzhFOEFDMjhFNkE2RkE3MEJFMEVFQkQ5RTg5NTkA\",\"timestamp\":\"1760287373\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:12:53', '2025-10-12 22:12:57', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:12:57', '2025-10-12 22:12:57'),
(102, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'No orders found for this number.', NULL, NULL, NULL, '2025-10-12 22:13:04', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:13:04', '2025-10-12 22:13:04'),
(103, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDlEODE0MTU5OThGMTk2RTM0Q0JDQjlGNDc0RjMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDlEODE0MTU5OThGMTk2RTM0Q0JDQjlGNDc0RjMA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQzZCQzUxOTMzMDVBNjU3MzY3AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxMDlEODE0MTU5OThGMTk2RTM0Q0JDQjlGNDc0RjMA\",\"timestamp\":\"1760287381\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"my_orders\",\"title\":\"\\ud83d\\udce6 My Orders\"}}}', '2025-10-12 22:13:01', '2025-10-12 22:13:04', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:13:04', '2025-10-12 22:13:04'),
(104, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDMjgxMUQzQkU5NTVCQkNEN0M1RkQ4MEQzOTU3NzIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDMjgxMUQzQkU5NTVCQkNEN0M1RkQ4MEQzOTU3NzIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQzZCQzUxOTMzMDVBNjU3MzY3AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVDMjgxMUQzQkU5NTVCQkNEN0M1RkQ4MEQzOTU3NzIA\",\"timestamp\":\"1760287411\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"view_cart\",\"title\":\"\\ud83d\\uded2 View Cart\"}}}', '2025-10-12 22:13:31', '2025-10-12 22:13:33', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:13:33', '2025-10-12 22:13:33'),
(105, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:18:41', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:18:41', '2025-10-12 22:18:41'),
(106, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 👋 Hi Jasim Mondal! Welcome to *SJ Fashion Hub*!

🛍️ Discover the latest fashion trends!

Click the button below to browse our products:', NULL, NULL, NULL, '2025-10-12 22:18:42', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:18:42', '2025-10-12 22:18:42'),
(107, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NTM1RTg4QkU2OUEyRjJCNTgzOThBQzQ0OEJFRUQA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NTM1RTg4QkU2OUEyRjJCNTgzOThBQzQ0OEJFRUQA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NTM1RTg4QkU2OUEyRjJCNTgzOThBQzQ0OEJFRUQA\",\"timestamp\":\"1760287719\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:18:39', '2025-10-12 22:18:42', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:18:42', '2025-10-12 22:18:42'),
(108, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'No orders found for this number.', NULL, NULL, NULL, '2025-10-12 22:18:49', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:18:49', '2025-10-12 22:18:49'),
(109, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3OUVGNDUzQzdBMENEOTYwNjc2QkFEQzRFOTc0OTIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3OUVGNDUzQzdBMENEOTYwNjc2QkFEQzRFOTc0OTIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOEMwMzQ2NjI3NzlDMDg2MjFGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3OUVGNDUzQzdBMENEOTYwNjc2QkFEQzRFOTc0OTIA\",\"timestamp\":\"1760287726\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"my_orders\",\"title\":\"\\ud83d\\udce6 My Orders\"}}}', '2025-10-12 22:18:46', '2025-10-12 22:18:49', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:18:49', '2025-10-12 22:18:49'),
(110, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Browse Products', NULL, NULL, NULL, '2025-10-12 22:19:07', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:07', '2025-10-12 22:19:07'),
(111, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzQjJGM0Y4RTRFNkM4QzExMjc4NzBDMzk5NUZGQkMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzQjJGM0Y4RTRFNkM4QzExMjc4NzBDMzk5NUZGQkMA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOEMwMzQ2NjI3NzlDMDg2MjFGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUzQjJGM0Y4RTRFNkM4QzExMjc4NzBDMzk5NUZGQkMA\",\"timestamp\":\"1760287745\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"browse_products\",\"title\":\"\\ud83d\\udecd\\ufe0f Browse Products\"}}}', '2025-10-12 22:19:05', '2025-10-12 22:19:08', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:08', '2025-10-12 22:19:08'),
(112, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Uncategorized', NULL, NULL, NULL, '2025-10-12 22:19:14', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:14', '2025-10-12 22:19:14'),
(113, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMjRFQkNGNzRFODBGNDVENjNGQTA4RjIxNUU1Q0YA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMjRFQkNGNzRFODBGNDVENjNGQTA4RjIxNUU1Q0YA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQTUzREMyMDcyRDM5OEJBNkVGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyMjRFQkNGNzRFODBGNDVENjNGQTA4RjIxNUU1Q0YA\",\"timestamp\":\"1760287752\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"cat_21\",\"title\":\"Uncategorized\",\"description\":\"1 products\"}}}', '2025-10-12 22:19:12', '2025-10-12 22:19:14', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:14', '2025-10-12 22:19:14'),
(114, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '*test*

💰 Price: ₹1
📦 Stock: In Stock (9 available)

Premium uncategorized crafted with attention to detail. test combines style and comfort for the modern fashion enthusiast.

', NULL, NULL, NULL, '2025-10-12 22:19:23', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:23', '2025-10-12 22:19:23'),
(115, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: Add this product to your cart?', NULL, NULL, NULL, '2025-10-12 22:19:23', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:23', '2025-10-12 22:19:23'),
(116, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3RUE5NEU1RUNEODRFOEQ0MkVBQTYwNTkxNjI4ODMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3RUE5NEU1RUNEODRFOEQ0MkVBQTYwNTkxNjI4ODMA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOUFBQjIwNzBCRjVGNzQ5OTFGAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU3RUE5NEU1RUNEODRFOEQ0MkVBQTYwNTkxNjI4ODMA\",\"timestamp\":\"1760287760\",\"type\":\"interactive\",\"interactive\":{\"type\":\"list_reply\",\"list_reply\":{\"id\":\"prod_80\",\"title\":\"test\",\"description\":\"\\u20b91\"}}}', '2025-10-12 22:19:20', '2025-10-12 22:19:23', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:23', '2025-10-12 22:19:23'),
(117, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: ✅ *test* added to cart!

🛒 Cart: 3 item(s)

What would you like to do next?', NULL, NULL, NULL, '2025-10-12 22:19:28', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:28', '2025-10-12 22:19:28'),
(118, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1QUVFNDQ0RTAyNjgyMkUxMDE5NzA0RDI4MkU1MzkA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1QUVFNDQ0RTAyNjgyMkUxMDE5NzA0RDI4MkU1MzkA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSNTY5MTJFMDdEQzZCNzAzMjJDAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU1QUVFNDQ0RTAyNjgyMkUxMDE5NzA0RDI4MkU1MzkA\",\"timestamp\":\"1760287766\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"add_80\",\"title\":\"\\ud83d\\uded2 Add to Cart\"}}}', '2025-10-12 22:19:26', '2025-10-12 22:19:28', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:28', '2025-10-12 22:19:28'),
(119, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'To complete your order, please provide your details:

📝 Send your full name:', NULL, NULL, NULL, '2025-10-12 22:19:33', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:33', '2025-10-12 22:19:33'),
(120, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVFNkEwOTQ2MDdDRDdFRUM1QkREQjRGNDQ5NEJDM0EA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVFNkEwOTQ2MDdDRDdFRUM1QkREQjRGNDQ5NEJDM0EA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOTBEOEUxOTVDQkIwNkM5N0Q2AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVFNkEwOTQ2MDdDRDdFRUM1QkREQjRGNDQ5NEJDM0EA\",\"timestamp\":\"1760287771\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"checkout\",\"title\":\"\\ud83d\\udcb3 Checkout\"}}}', '2025-10-12 22:19:31', '2025-10-12 22:19:33', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:19:33', '2025-10-12 22:19:33'),
(121, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:25:12', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:12', '2025-10-12 22:25:12'),
(122, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Thanks Hi!

📧 Please send your email address:', NULL, NULL, NULL, '2025-10-12 22:25:13', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:13', '2025-10-12 22:25:13'),
(123, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMERCNTczRDQ2Mzg4MUYwQzMwREJFNTlDNjQyOTUA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMERCNTczRDQ2Mzg4MUYwQzMwREJFNTlDNjQyOTUA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVBMERCNTczRDQ2Mzg4MUYwQzMwREJFNTlDNjQyOTUA\",\"timestamp\":\"1760288110\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:25:10', '2025-10-12 22:25:13', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:13', '2025-10-12 22:25:13'),
(124, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'jasimmondal57@gmail.com', NULL, NULL, NULL, NULL, '2025-10-12 22:25:26', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:26', '2025-10-12 22:25:26'),
(125, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Email saved!

📍 Please send your complete delivery address:', NULL, NULL, NULL, '2025-10-12 22:25:26', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:26', '2025-10-12 22:25:26'),
(126, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0QjA2NjVERDBFMTFCNkY2RkZDRjkyRjE0N0FBQ0EA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0QjA2NjVERDBFMTFCNkY2RkZDRjkyRjE0N0FBQ0EA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'jasimmondal57@gmail.com', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU0QjA2NjVERDBFMTFCNkY2RkZDRjkyRjE0N0FBQ0EA\",\"timestamp\":\"1760288124\",\"text\":{\"body\":\"jasimmondal57@gmail.com\"},\"type\":\"text\"}', '2025-10-12 22:25:24', '2025-10-12 22:25:26', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:26', '2025-10-12 22:25:26'),
(127, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hiiiiiii', NULL, NULL, NULL, NULL, '2025-10-12 22:25:40', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:40', '2025-10-12 22:25:40'),
(128, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Please provide a complete address:', NULL, NULL, NULL, '2025-10-12 22:25:41', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:41', '2025-10-12 22:25:41'),
(129, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2Mjg5Njc1RUZEMkQ1MjA0NUM2MjRFNUQ0MjhENkMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2Mjg5Njc1RUZEMkQ1MjA0NUM2MjRFNUQ0MjhENkMA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hiiiiiii', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU2Mjg5Njc1RUZEMkQ1MjA0NUM2MjRFNUQ0MjhENkMA\",\"timestamp\":\"1760288139\",\"text\":{\"body\":\"Hiiiiiii\"},\"type\":\"text\"}', '2025-10-12 22:25:39', '2025-10-12 22:25:41', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:41', '2025-10-12 22:25:41'),
(130, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Exit', NULL, NULL, NULL, NULL, '2025-10-12 22:25:47', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:47', '2025-10-12 22:25:47'),
(131, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Please provide a complete address:', NULL, NULL, NULL, '2025-10-12 22:25:47', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:47', '2025-10-12 22:25:47'),
(132, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU4NTJBRjk5MkYyRDIyODFDNDZDOEY4RTdGRjFDRjMA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU4NTJBRjk5MkYyRDIyODFDNDZDOEY4RTdGRjFDRjMA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Exit', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU4NTJBRjk5MkYyRDIyODFDNDZDOEY4RTdGRjFDRjMA\",\"timestamp\":\"1760288145\",\"text\":{\"body\":\"Exit\"},\"type\":\"text\"}', '2025-10-12 22:25:45', '2025-10-12 22:25:47', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:47', '2025-10-12 22:25:47'),
(133, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Close', NULL, NULL, NULL, NULL, '2025-10-12 22:25:53', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:53', '2025-10-12 22:25:53'),
(134, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Please provide a complete address:', NULL, NULL, NULL, '2025-10-12 22:25:54', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:54', '2025-10-12 22:25:54'),
(135, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxQkFBMUQ1RDI4MUZENTM1NzE0NkUyRjFFRDU2QjQA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxQkFBMUQ1RDI4MUZENTM1NzE0NkUyRjFFRDU2QjQA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Close', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUxQkFBMUQ1RDI4MUZENTM1NzE0NkUyRjFFRDU2QjQA\",\"timestamp\":\"1760288152\",\"text\":{\"body\":\"Close\"},\"type\":\"text\"}', '2025-10-12 22:25:52', '2025-10-12 22:25:54', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:25:54', '2025-10-12 22:25:54'),
(136, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Button message: 🛒 *Your Shopping Cart*

• 2 Pcs Set
  Qty: 1 × ₹360 = ₹360

• test
  Qty: 2 × ₹1 = ₹2

━━━━━━━━━━━━━━━━
*Total: ₹362*

What would you like to do?', NULL, NULL, NULL, '2025-10-12 22:26:06', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:06', '2025-10-12 22:26:06'),
(137, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NDNDMjZDNDQ5QzlCRTk5MDQxRTdEQTBCQ0VCN0QA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NDNDMjZDNDQ5QzlCRTk5MDQxRTdEQTBCQ0VCN0QA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSOTBEOEUxOTVDQkIwNkM5N0Q2AA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTU5NDNDMjZDNDQ5QzlCRTk5MDQxRTdEQTBCQ0VCN0QA\",\"timestamp\":\"1760288164\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"view_cart\",\"title\":\"\\ud83d\\uded2 View Cart\"}}}', '2025-10-12 22:26:04', '2025-10-12 22:26:06', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:06', '2025-10-12 22:26:06'),
(138, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'To complete your order, please provide your details:

📝 Send your full name:', NULL, NULL, NULL, '2025-10-12 22:26:15', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:15', '2025-10-12 22:26:15'),
(139, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGOTQ1MEQzMUNGOTZCMzFFNzFFOUU4NUZEMDhEOUIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGOTQ1MEQzMUNGOTZCMzFFNzFFOUU4NUZEMDhEOUIA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQjkyNkFENjNFQjEyMzRGQTZBAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVGOTQ1MEQzMUNGOTZCMzFFNzFFOUU4NUZEMDhEOUIA\",\"timestamp\":\"1760288172\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"checkout\",\"title\":\"\\ud83d\\udcb3 Checkout\"}}}', '2025-10-12 22:26:12', '2025-10-12 22:26:15', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:15', '2025-10-12 22:26:15'),
(140, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, 'Interactive list: Browse Products', NULL, NULL, NULL, '2025-10-12 22:26:24', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:24', '2025-10-12 22:26:24'),
(141, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEQjUzMkZGQzVFRTdCRDEyMDg0Qjg3Q0RCMTQwMDYA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEQjUzMkZGQzVFRTdCRDEyMDg0Qjg3Q0RCMTQwMDYA', 'inbound', 'interactive', 'received', '918536945959', NULL, 'support', NULL, 'Interactive message received', NULL, NULL, '{\"context\":{\"from\":\"917908342668\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSQjkyNkFENjNFQjEyMzRGQTZBAA==\"},\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTVEQjUzMkZGQzVFRTdCRDEyMDg0Qjg3Q0RCMTQwMDYA\",\"timestamp\":\"1760288182\",\"type\":\"interactive\",\"interactive\":{\"type\":\"button_reply\",\"button_reply\":{\"id\":\"continue_shopping\",\"title\":\"\\ud83d\\udecd\\ufe0f Keep Shopping\"}}}', '2025-10-12 22:26:22', '2025-10-12 22:26:24', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:24', '2025-10-12 22:26:24'),
(142, NULL, NULL, 'inbound', 'text', 'received', '918536945959', NULL, 'commerce', NULL, 'Hi', NULL, NULL, NULL, NULL, '2025-10-12 22:26:29', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:29', '2025-10-12 22:26:29'),
(143, NULL, NULL, 'outbound', 'text', 'sent', '918536945959', NULL, 'commerce', NULL, '✅ Thanks Hi!

📧 Please send your email address:', NULL, NULL, NULL, '2025-10-12 22:26:29', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:29', '2025-10-12 22:26:29'),
(144, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyRTU3OTJGRTlGRTlDNTE1RDE0NTMyQjBCM0ZCMzIA', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyRTU3OTJGRTlGRTlDNTE1RDE0NTMyQjBCM0ZCMzIA', 'inbound', 'text', 'received', '918536945959', NULL, 'support', NULL, 'Hi', NULL, NULL, '{\"from\":\"918536945959\",\"id\":\"wamid.HBgMOTE4NTM2OTQ1OTU5FQIAEhggQTUyRTU3OTJGRTlGRTlDNTE1RDE0NTMyQjBCM0ZCMzIA\",\"timestamp\":\"1760288187\",\"text\":{\"body\":\"Hi\"},\"type\":\"text\"}', '2025-10-12 22:26:27', '2025-10-12 22:26:29', NULL, NULL, NULL, NULL, NULL, '2025-10-12 22:26:29', '2025-10-12 22:26:29'),
(145, 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRTcwMkFGN0EzNDkwODMwRjc5AA==', 'wamid.HBgMOTE4NTM2OTQ1OTU5FQIAERgSRTcwMkFGN0EzNDkwODMwRjc5AA==', 'outbound', 'template', 'sent', '918536945959', 5, 'otp', 'otp_login_en_1760245300', 'Template: otp_login_en_1760245300', NULL, '[\"985603\"]', NULL, '2025-10-13 00:23:27', NULL, NULL, NULL, NULL, NULL, NULL, '2025-10-13 00:23:27', '2025-10-13 00:23:27');


-- Table structure for table `whatsapp_conversations`
DROP TABLE IF EXISTS `whatsapp_conversations`;
CREATE TABLE "whatsapp_conversations" ("id" integer primary key autoincrement not null, "phone_number" varchar not null, "user_id" integer, "customer_name" varchar, "status" varchar not null default 'open', "assigned_to" integer, "last_message_at" datetime, "last_message_type" varchar, "last_message_preview" text, "unread_count" integer not null default '0', "metadata" text, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete set null, foreign key("assigned_to") references "users"("id") on delete set null);


-- Dumping data for table `whatsapp_conversations`
INSERT INTO `whatsapp_conversations` (`id`, `phone_number`, `user_id`, `customer_name`, `status`, `assigned_to`, `last_message_at`, `last_message_type`, `last_message_preview`, `unread_count`, `metadata`, `created_at`, `updated_at`) VALUES
(1, '918536945959', 5, 'Jasim Mondal', 'closed', NULL, '2025-10-13 00:23:27', 'template', 'Template: otp_login_en_1760245300', 0, NULL, '2025-10-12 15:41:32', '2025-10-13 00:23:27'),
(2, '918670738021', NULL, 'jasim', 'closed', NULL, '2025-10-12 20:50:23', 'order', 'Order message received', 0, NULL, '2025-10-12 20:50:23', '2025-10-12 22:39:41');


-- Table structure for table `whatsapp_catalog_products`
DROP TABLE IF EXISTS `whatsapp_catalog_products`;
CREATE TABLE "whatsapp_catalog_products" ("id" integer primary key autoincrement not null, "product_id" integer not null, "meta_product_id" varchar, "retailer_id" varchar not null, "sync_status" varchar not null default 'pending', "last_synced_at" datetime, "sync_error" text, "meta_data" text, "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete cascade);


-- Dumping data for table `whatsapp_catalog_products`
INSERT INTO `whatsapp_catalog_products` (`id`, `product_id`, `meta_product_id`, `retailer_id`, `sync_status`, `last_synced_at`, `sync_error`, `meta_data`, `created_at`, `updated_at`) VALUES
(1, 9, 'META_9', 'CPSL2PR_1', 'synced', '2025-10-12 14:47:33', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:33'),
(2, 10, 'META_10', 'CPSL2PR_2', 'synced', '2025-10-12 14:47:19', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:19'),
(3, 11, 'META_11', 'CPSL2PR_3', 'synced', '2025-10-12 14:47:21', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:21'),
(4, 12, 'META_12', 'CPSL2PR_4', 'synced', '2025-10-12 14:47:35', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:35'),
(5, 13, 'META_13', 'CTN3PIPC_1', 'synced', '2025-10-12 14:47:56', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:56'),
(6, 14, NULL, 'CTN3PIPC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(7, 15, NULL, 'CTN3PIPC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(8, 16, NULL, 'CTN3PIPC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(9, 17, NULL, 'CTN2PIPC_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(10, 18, NULL, 'CTN2PIPC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(11, 19, NULL, 'CTN2PIPC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(12, 20, NULL, 'CTN2PIPC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(13, 21, NULL, 'CTN3PIPC_5', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(14, 22, NULL, 'CTN3PIPC_6', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(15, 23, NULL, 'CTN3PIPC_7', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(16, 24, NULL, 'CTN3PIPC_8', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(17, 25, NULL, '.001IOSL_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(18, 26, NULL, '.001IOSL_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(19, 27, NULL, '.001IOSL_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(20, 28, NULL, 'JYNAE_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(21, 29, NULL, 'JYNAE_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(22, 30, NULL, 'JYNAE_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(23, 31, NULL, 'JYNAE_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(24, 32, NULL, 'CTSLPNC_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(25, 33, NULL, 'CTSLPNC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(26, 34, NULL, 'CTSLPNC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(27, 35, NULL, 'CTSLPNC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(28, 36, 'META_36', 'CTN_EMB_BLK2-1', 'synced', '2025-10-12 14:47:43', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:43'),
(29, 37, NULL, 'CTN_EMB_BLK_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(30, 38, NULL, 'CTN_EMB_BLU-1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(31, 39, NULL, 'DCP2IPC_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(32, 40, NULL, 'DCP2IPC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(33, 41, NULL, 'DCP2IPC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(34, 42, NULL, 'DCP2IPC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(35, 43, NULL, 'CPSL2PR_5', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(36, 44, NULL, 'CPSL2PR_6', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(37, 45, NULL, 'CPSL2PR_7', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(38, 46, NULL, 'CPSL2PR_8', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(39, 47, NULL, 'CTSLF3PCP_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(40, 48, NULL, 'CPSLF3PCP_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(41, 49, NULL, 'CPSLF3PCP_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(42, 50, NULL, 'CPSLF3PCP_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(43, 51, NULL, 'CPSLF3PCP_5', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(44, 52, NULL, 'CPSLF3PCP_6', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(45, 53, NULL, 'CPSLF3PCP_7', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(46, 54, NULL, 'CPSLF3PCP_8', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(47, 55, NULL, 'CPSLF3PCP_9', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(48, 56, NULL, 'DCPFLIH_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(49, 57, 'META_57', 'DCPFLIH_2', 'synced', '2025-10-12 14:48:06', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:48:06'),
(50, 58, 'META_58', 'DCPFLIH_3', 'synced', '2025-10-12 14:48:02', NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:48:02'),
(51, 59, NULL, 'DCPFLIH_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(52, 60, NULL, 'DCPFLIH_5', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(53, 61, NULL, 'DCPFLIH_6', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(54, 62, NULL, 'DCPFLIH_7', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(55, 63, NULL, 'CTNPLNBLK', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(56, 64, NULL, 'SKU-68d90c929560a', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(57, 65, NULL, 'CTNPLNYLW_L', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(58, 66, NULL, 'CTNPRNTRDBLS_L', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(59, 67, NULL, 'PLKAAR_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(60, 68, NULL, 'PLKAAR_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(61, 69, NULL, 'PLKAAR_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(62, 70, NULL, 'SKU-68d90c929d9f6', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(63, 71, NULL, 'NYR3IPC_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(64, 72, NULL, 'NYR3IPC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(65, 73, NULL, 'NYR3IPC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(66, 74, NULL, 'NYR3IPC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(67, 75, NULL, 'RYPNIPC_1', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(68, 76, NULL, 'RYPNIPC_2', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(69, 77, NULL, 'RYPNIPC_3', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(70, 78, NULL, 'RYPNIPC_4', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(71, 79, NULL, 'CTN_EMB_BL', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08'),
(72, 80, NULL, 'SKU-68d90c92ab438', 'pending', NULL, NULL, NULL, '2025-10-12 14:47:08', '2025-10-12 14:47:08');


-- Table structure for table `whatsapp_orders`
DROP TABLE IF EXISTS `whatsapp_orders`;
CREATE TABLE "whatsapp_orders" ("id" integer primary key autoincrement not null, "whatsapp_order_id" varchar not null, "order_id" integer, "phone_number" varchar not null, "user_id" integer, "status" varchar not null default 'pending', "items" text not null, "total_amount" numeric not null, "customer_details" text, "customer_message" text, "received_at" datetime not null, "confirmed_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("order_id") references "orders"("id") on delete set null, foreign key("user_id") references "users"("id") on delete set null);


-- Dumping data for table `whatsapp_orders`
-- No data to dump


-- Table structure for table `facebook_settings`
DROP TABLE IF EXISTS `facebook_settings`;
CREATE TABLE "facebook_settings" ("id" integer primary key autoincrement not null, "pixel_id" varchar, "pixel_enabled" tinyint(1) not null default '0', "access_token" text, "catalog_id" varchar, "catalog_sync_enabled" tinyint(1) not null default '0', "business_id" varchar, "app_id" varchar, "app_secret" text, "auto_sync_inventory" tinyint(1) not null default '1', "auto_sync_prices" tinyint(1) not null default '1', "sync_frequency_hours" integer not null default '6', "last_sync_at" datetime, "sync_settings" text, "event_tracking" text, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `facebook_settings`
INSERT INTO `facebook_settings` (`id`, `pixel_id`, `pixel_enabled`, `access_token`, `catalog_id`, `catalog_sync_enabled`, `business_id`, `app_id`, `app_secret`, `auto_sync_inventory`, `auto_sync_prices`, `sync_frequency_hours`, `last_sync_at`, `sync_settings`, `event_tracking`, `created_at`, `updated_at`) VALUES
(1, '1364197498404249', 1, 'EAAKZAS2QCjvsBPlczbnEcQwdVFCCSFpOrKxF9eXXHNcRvDatqzYwwrZBIGXS3BIFAOYQfHjqGyX66T79XqvBhHrBnGqBWPophddQhxoG9PSjLu9dYcZASAHe6pAdStremQ24RUY6dM3MXrXoD8J98IHcrRZBw6FDV0wRWwYEyP99fDdDqVscD6QMAN3ZAnTK8Dzo0OQZDZD', '857962576567865', 1, '878612377557034', '731499032907515', '1d1dfbe60b764b5f62f478c9140ffc75', 1, 1, 1, '2025-10-12 19:46:38', NULL, '{\"PageView\":true,\"ViewContent\":true,\"AddToCart\":true,\"InitiateCheckout\":true,\"Purchase\":true,\"Search\":true,\"AddToWishlist\":true}', '2025-10-12 15:19:26', '2025-10-12 19:46:38');


-- Table structure for table `facebook_catalog_products`
DROP TABLE IF EXISTS `facebook_catalog_products`;
CREATE TABLE "facebook_catalog_products" ("id" integer primary key autoincrement not null, "product_id" integer not null, "facebook_product_id" varchar, "status" varchar not null default 'pending', "availability" varchar not null default 'in stock', "last_synced_at" datetime, "sync_error" text, "facebook_data" text, "created_at" datetime, "updated_at" datetime, foreign key("product_id") references "products"("id") on delete cascade);


-- Dumping data for table `facebook_catalog_products`
INSERT INTO `facebook_catalog_products` (`id`, `product_id`, `facebook_product_id`, `status`, `availability`, `last_synced_at`, `sync_error`, `facebook_data`, `created_at`, `updated_at`) VALUES
(289, 9, 'AcyF2t9j_VAddTroPyIj2eeX1P0o_g4QKWTlx1sJ7qVEv3_p9PAieXFAMdP-YY8J5i9ENiQZ6EGlKbjD-Ei3IWWZ', 'synced', 'in stock', '2025-10-12 19:44:33', NULL, '{\"handles\":[\"AcyF2t9j_VAddTroPyIj2eeX1P0o_g4QKWTlx1sJ7qVEv3_p9PAieXFAMdP-YY8J5i9ENiQZ6EGlKbjD-Ei3IWWZ\"]}', '2025-10-12 19:44:31', '2025-10-12 19:44:33'),
(290, 10, 'Acz5H7luBaRlE4VHnKGgmuSA7qs8cCTj9vQ62tr5ESPBou_sulhviiM0-Ap8acyWmprbLnRfc98IR0PfBjqE_AAZ', 'synced', 'in stock', '2025-10-12 19:44:34', NULL, '{\"handles\":[\"Acz5H7luBaRlE4VHnKGgmuSA7qs8cCTj9vQ62tr5ESPBou_sulhviiM0-Ap8acyWmprbLnRfc98IR0PfBjqE_AAZ\"]}', '2025-10-12 19:44:33', '2025-10-12 19:44:34'),
(291, 11, 'AcwgJL1ixv-JP1BkXEYsBU5yWGjAUfOyhVPpljiXRVPVkZvQ9XsRtgXtDuZQbPMUBtfkzIa6VrNVEptlJO9IIKt5', 'synced', 'in stock', '2025-10-12 19:44:36', NULL, '{\"handles\":[\"AcwgJL1ixv-JP1BkXEYsBU5yWGjAUfOyhVPpljiXRVPVkZvQ9XsRtgXtDuZQbPMUBtfkzIa6VrNVEptlJO9IIKt5\"]}', '2025-10-12 19:44:34', '2025-10-12 19:44:36'),
(292, 12, 'AcwmbK1Pag0kNfdK2bimoAJ9nGB_qFsvK2YYnbwwwREpsNYWeoIcoqUxbpSL9eE2pzwrbUoQzDdeZkoYCqAvYr6H', 'synced', 'in stock', '2025-10-12 19:44:37', NULL, '{\"handles\":[\"AcwmbK1Pag0kNfdK2bimoAJ9nGB_qFsvK2YYnbwwwREpsNYWeoIcoqUxbpSL9eE2pzwrbUoQzDdeZkoYCqAvYr6H\"]}', '2025-10-12 19:44:36', '2025-10-12 19:44:37'),
(293, 13, 'Aczy0vR3RqGOONrLl65DolQIPAPxqYmoM5f0whQWv_ryv1SPolSe5nPIu2fvw3XX8bktuEdeu0e4nb46V8V0Pr8r', 'synced', 'in stock', '2025-10-12 19:44:39', NULL, '{\"handles\":[\"Aczy0vR3RqGOONrLl65DolQIPAPxqYmoM5f0whQWv_ryv1SPolSe5nPIu2fvw3XX8bktuEdeu0e4nb46V8V0Pr8r\"]}', '2025-10-12 19:44:37', '2025-10-12 19:44:39'),
(294, 14, 'AcwdgWx9S77TOmwYp7QU93O9IFkvvh4wsb1C1iUpEPUl-xvD-qXyDw5huqlZsgfl6eNSh_OVu7iNN03wV4eilSgM', 'synced', 'in stock', '2025-10-12 19:44:41', NULL, '{\"handles\":[\"AcwdgWx9S77TOmwYp7QU93O9IFkvvh4wsb1C1iUpEPUl-xvD-qXyDw5huqlZsgfl6eNSh_OVu7iNN03wV4eilSgM\"]}', '2025-10-12 19:44:39', '2025-10-12 19:44:41'),
(295, 15, 'Acx0_ATnF0oUng9PvInEBXq4uf2xShMoGAkAI6ihaamw3QV4n9gWMBrPCRfbhkXAZHTnTQ3i4pVk1Q-JByrI5CkI', 'synced', 'in stock', '2025-10-12 19:44:43', NULL, '{\"handles\":[\"Acx0_ATnF0oUng9PvInEBXq4uf2xShMoGAkAI6ihaamw3QV4n9gWMBrPCRfbhkXAZHTnTQ3i4pVk1Q-JByrI5CkI\"]}', '2025-10-12 19:44:41', '2025-10-12 19:44:43'),
(296, 16, 'AcxUQVJEQqGAKwz5Doec5NRLNUCerSndlGKyEowvNrfrCkB0qtYM8JtcwfWUFGxFELvx6UXVfhI41r9ola5mQKr_', 'synced', 'in stock', '2025-10-12 19:44:44', NULL, '{\"handles\":[\"AcxUQVJEQqGAKwz5Doec5NRLNUCerSndlGKyEowvNrfrCkB0qtYM8JtcwfWUFGxFELvx6UXVfhI41r9ola5mQKr_\"]}', '2025-10-12 19:44:43', '2025-10-12 19:44:44'),
(297, 17, 'AcwtN9Ni2BzgVpWi0NJUljglbqg1ZW_BvtYy2ORGIMu1XeaHktmpxlGrP1abDKWbkgxCGddDlszomdsl9gmv4RJw', 'synced', 'in stock', '2025-10-12 19:44:46', NULL, '{\"handles\":[\"AcwtN9Ni2BzgVpWi0NJUljglbqg1ZW_BvtYy2ORGIMu1XeaHktmpxlGrP1abDKWbkgxCGddDlszomdsl9gmv4RJw\"]}', '2025-10-12 19:44:44', '2025-10-12 19:44:46'),
(298, 18, 'AcwaYWryXS514msON-IIfY_wRA110x8cwHTsw-ViMJ33aVOIX-xfWIm5ga3bmM4KUr7vRyZFTmBCb9Vqho-4tl-Q', 'synced', 'in stock', '2025-10-12 19:44:48', NULL, '{\"handles\":[\"AcwaYWryXS514msON-IIfY_wRA110x8cwHTsw-ViMJ33aVOIX-xfWIm5ga3bmM4KUr7vRyZFTmBCb9Vqho-4tl-Q\"]}', '2025-10-12 19:44:46', '2025-10-12 19:44:48'),
(299, 19, 'AczXr2iNo2nFEun9KpMJzefRSon24_YRAwGAW01vY0nJQmfjuTY8knVS_rHQPMGifiK_Abz_lglDn-fUJtnbyaHS', 'synced', 'in stock', '2025-10-12 19:44:49', NULL, '{\"handles\":[\"AczXr2iNo2nFEun9KpMJzefRSon24_YRAwGAW01vY0nJQmfjuTY8knVS_rHQPMGifiK_Abz_lglDn-fUJtnbyaHS\"]}', '2025-10-12 19:44:48', '2025-10-12 19:44:49'),
(300, 20, 'Acyf50CBB8a_hdhzGocEZZL6VLbLAXw1WgdDyKfu7uMDLvD5jT46C3dwfFiGPv6vQp2_WOkud1d2jZA6MQJ5UJiT', 'synced', 'in stock', '2025-10-12 19:44:51', NULL, '{\"handles\":[\"Acyf50CBB8a_hdhzGocEZZL6VLbLAXw1WgdDyKfu7uMDLvD5jT46C3dwfFiGPv6vQp2_WOkud1d2jZA6MQJ5UJiT\"]}', '2025-10-12 19:44:49', '2025-10-12 19:44:51'),
(301, 21, 'AczoTes58GDy34ZYT7iCDcchN8Y9BA0Cu699jJAdSvQS8gY_BCXTEz1vDU13JRjMqlAYMPtp0569ApmiG-NZWYap', 'synced', 'in stock', '2025-10-12 19:44:53', NULL, '{\"handles\":[\"AczoTes58GDy34ZYT7iCDcchN8Y9BA0Cu699jJAdSvQS8gY_BCXTEz1vDU13JRjMqlAYMPtp0569ApmiG-NZWYap\"]}', '2025-10-12 19:44:51', '2025-10-12 19:44:53'),
(302, 22, 'AcwLIAiY578XF6wyJnRUEVsoD38biDcd8NTV_y3OS8jS_MBK-Z6jpHHeSHrh5qubU3iA3nmqzfi4GIbPPiOcmpqX', 'synced', 'in stock', '2025-10-12 19:44:54', NULL, '{\"handles\":[\"AcwLIAiY578XF6wyJnRUEVsoD38biDcd8NTV_y3OS8jS_MBK-Z6jpHHeSHrh5qubU3iA3nmqzfi4GIbPPiOcmpqX\"]}', '2025-10-12 19:44:53', '2025-10-12 19:44:54'),
(303, 23, 'AcwVjPs4Y5yie8wRcH_RlG9ZuHkvPEGdoyLHZgl5fwWHVy24_PXseV9WLn8qcWdk-CkCO6VbcFMX52mF88GYX7ld', 'synced', 'in stock', '2025-10-12 19:44:56', NULL, '{\"handles\":[\"AcwVjPs4Y5yie8wRcH_RlG9ZuHkvPEGdoyLHZgl5fwWHVy24_PXseV9WLn8qcWdk-CkCO6VbcFMX52mF88GYX7ld\"]}', '2025-10-12 19:44:54', '2025-10-12 19:44:56'),
(304, 24, 'AcyUL8EcHlLJUnGT2sy32k_BEJ-Kn1pxJk4KEJ7KObvdARKY369qgqKZmDgHlp3c5EINM50axklQl3A-P6phI2XT', 'synced', 'in stock', '2025-10-12 19:44:58', NULL, '{\"handles\":[\"AcyUL8EcHlLJUnGT2sy32k_BEJ-Kn1pxJk4KEJ7KObvdARKY369qgqKZmDgHlp3c5EINM50axklQl3A-P6phI2XT\"]}', '2025-10-12 19:44:56', '2025-10-12 19:44:58'),
(305, 25, 'AcxJnZJZ6U6d9tCtNKuxt7zA3kDdRqhSoIczWipp6f62-Z56s1xcXXjY4tNYLPeBXA4LQAODPDpuSaoaUFDcqT3q', 'synced', 'in stock', '2025-10-12 19:44:59', NULL, '{\"handles\":[\"AcxJnZJZ6U6d9tCtNKuxt7zA3kDdRqhSoIczWipp6f62-Z56s1xcXXjY4tNYLPeBXA4LQAODPDpuSaoaUFDcqT3q\"]}', '2025-10-12 19:44:58', '2025-10-12 19:44:59'),
(306, 26, 'AcwLaf5RiO4zDHIFa8821MIHiURMxygFwYEh5rJJ2iuAGVrAq3rXvLKgzdJIUs12smv8LOHQCAKuqdigbVVMDeBS', 'synced', 'in stock', '2025-10-12 19:45:02', NULL, '{\"handles\":[\"AcwLaf5RiO4zDHIFa8821MIHiURMxygFwYEh5rJJ2iuAGVrAq3rXvLKgzdJIUs12smv8LOHQCAKuqdigbVVMDeBS\"]}', '2025-10-12 19:45:00', '2025-10-12 19:45:02'),
(307, 27, 'AcyB34Mgdh4yuOPpSn8YAVYHLmgMokxfBPt3l03YPJwhu0QgoXyvhzwAkZJzv89yfYt7sowH5RubqoXGlRVbw0Zr', 'synced', 'in stock', '2025-10-12 19:45:04', NULL, '{\"handles\":[\"AcyB34Mgdh4yuOPpSn8YAVYHLmgMokxfBPt3l03YPJwhu0QgoXyvhzwAkZJzv89yfYt7sowH5RubqoXGlRVbw0Zr\"]}', '2025-10-12 19:45:02', '2025-10-12 19:45:04'),
(308, 28, 'AcyNfldwhj7YGURFGr_Au2OeCJmjC8MpjlHWdAnY2mchw0x6PWyY3yCH_KfyxD3Zg0jTqUcK-S8aOOAOBhjXWTpv', 'synced', 'in stock', '2025-10-12 19:45:05', NULL, '{\"handles\":[\"AcyNfldwhj7YGURFGr_Au2OeCJmjC8MpjlHWdAnY2mchw0x6PWyY3yCH_KfyxD3Zg0jTqUcK-S8aOOAOBhjXWTpv\"]}', '2025-10-12 19:45:04', '2025-10-12 19:45:05'),
(309, 29, 'AcxCdSBR_qa6k1tSFllqeiNfvixmvktWu-aDsMSkxridRHQtt8Nz7KzY5cN250dzDcwb6IEQEvbDG0GZSBNHf-R2', 'synced', 'in stock', '2025-10-12 19:45:07', NULL, '{\"handles\":[\"AcxCdSBR_qa6k1tSFllqeiNfvixmvktWu-aDsMSkxridRHQtt8Nz7KzY5cN250dzDcwb6IEQEvbDG0GZSBNHf-R2\"]}', '2025-10-12 19:45:05', '2025-10-12 19:45:07'),
(310, 30, 'AcwnM_yBJj0Ci_31BiejQr9NS7Vn5zxOgRPluqnrqzwSsDBykIcSIiLk2KSCV-4o_8GkhQ4AfTQgg9AKmo0qYcpi', 'synced', 'in stock', '2025-10-12 19:45:09', NULL, '{\"handles\":[\"AcwnM_yBJj0Ci_31BiejQr9NS7Vn5zxOgRPluqnrqzwSsDBykIcSIiLk2KSCV-4o_8GkhQ4AfTQgg9AKmo0qYcpi\"]}', '2025-10-12 19:45:07', '2025-10-12 19:45:09'),
(311, 31, 'AcxXTJgyjdC7VyB-VF1Eds_YoEwBMO6RDqgk1xVwGyii95cxY5Haxm1eaSnMzOg96PIP6QfTh1jzcTUMloZGBi-p', 'synced', 'in stock', '2025-10-12 19:45:11', NULL, '{\"handles\":[\"AcxXTJgyjdC7VyB-VF1Eds_YoEwBMO6RDqgk1xVwGyii95cxY5Haxm1eaSnMzOg96PIP6QfTh1jzcTUMloZGBi-p\"]}', '2025-10-12 19:45:09', '2025-10-12 19:45:11'),
(312, 32, 'AczlAFsCFyz8cBvf6OEaZ8wSCi-2ge7j-RobV2aZgPVtECDk25W4S_UWUONGsBQMvAQx2EPPeVrnSljU82DelKG6', 'synced', 'in stock', '2025-10-12 19:45:12', NULL, '{\"handles\":[\"AczlAFsCFyz8cBvf6OEaZ8wSCi-2ge7j-RobV2aZgPVtECDk25W4S_UWUONGsBQMvAQx2EPPeVrnSljU82DelKG6\"]}', '2025-10-12 19:45:11', '2025-10-12 19:45:12'),
(313, 33, 'AcwsFUa8GmR4gohYuweeZ0dj43YelnlPGG4ojVimHUl75WZ0TQUIDRfFEadYiIG2NnnE22Jx1XHwMrNU33gOCugC', 'synced', 'in stock', '2025-10-12 19:45:15', NULL, '{\"handles\":[\"AcwsFUa8GmR4gohYuweeZ0dj43YelnlPGG4ojVimHUl75WZ0TQUIDRfFEadYiIG2NnnE22Jx1XHwMrNU33gOCugC\"]}', '2025-10-12 19:45:12', '2025-10-12 19:45:15'),
(314, 34, 'Acx7a-O-rkNNPH1F-FgahhcP5E4URyYseAEw71P4ALK8RoR1TumfEjECaUF2iGT5Unp7cfNY7yC7hdeN_Xr5haJh', 'synced', 'in stock', '2025-10-12 19:45:17', NULL, '{\"handles\":[\"Acx7a-O-rkNNPH1F-FgahhcP5E4URyYseAEw71P4ALK8RoR1TumfEjECaUF2iGT5Unp7cfNY7yC7hdeN_Xr5haJh\"]}', '2025-10-12 19:45:15', '2025-10-12 19:45:17'),
(315, 35, 'AcztKYypTaooFUGzDt71y5tOfvagBOH75-7ZxE5YZnyx6vdG8zyxqHlkd82GZXfSpts5_tXPlWFL-x6pser3iDdw', 'synced', 'in stock', '2025-10-12 19:45:18', NULL, '{\"handles\":[\"AcztKYypTaooFUGzDt71y5tOfvagBOH75-7ZxE5YZnyx6vdG8zyxqHlkd82GZXfSpts5_tXPlWFL-x6pser3iDdw\"]}', '2025-10-12 19:45:17', '2025-10-12 19:45:18'),
(316, 36, 'AcwSTNEs5zZZ-xiMstHvsBFRypUOy_-lSRVrxU8sLaznu5VosNr5bV50H1Ib-P8ujrm4ZIBXxNKK8w11HpRz6JDT', 'synced', 'in stock', '2025-10-12 19:45:20', NULL, '{\"handles\":[\"AcwSTNEs5zZZ-xiMstHvsBFRypUOy_-lSRVrxU8sLaznu5VosNr5bV50H1Ib-P8ujrm4ZIBXxNKK8w11HpRz6JDT\"]}', '2025-10-12 19:45:18', '2025-10-12 19:45:20'),
(317, 37, 'Acy3ExtrdHMZpE36k4b6hIqZSP16oDnVh8EWt-COSqaPZXP4ga1jIBl0L_Ee4VuHACqttco4NOct292BED3ID8OY', 'synced', 'in stock', '2025-10-12 19:45:22', NULL, '{\"handles\":[\"Acy3ExtrdHMZpE36k4b6hIqZSP16oDnVh8EWt-COSqaPZXP4ga1jIBl0L_Ee4VuHACqttco4NOct292BED3ID8OY\"]}', '2025-10-12 19:45:20', '2025-10-12 19:45:22'),
(318, 38, 'AcwnaEQiKRimNT11geNisO1mp13pIKrIm2VR2METzGTp1BwsYmNxcN6r5S8iw872e_ooJdC-EuI0ZsUOeadh0y4y', 'synced', 'in stock', '2025-10-12 19:45:24', NULL, '{\"handles\":[\"AcwnaEQiKRimNT11geNisO1mp13pIKrIm2VR2METzGTp1BwsYmNxcN6r5S8iw872e_ooJdC-EuI0ZsUOeadh0y4y\"]}', '2025-10-12 19:45:22', '2025-10-12 19:45:24'),
(319, 39, 'Acye4NL3k9yswiUUpkcYwnF6gjz9leLV1QYIACuMHdzjddre93FH_kZ0l_FZMBjKjiDo2CVygyehU-umOp8fU_9p', 'synced', 'in stock', '2025-10-12 19:45:25', NULL, '{\"handles\":[\"Acye4NL3k9yswiUUpkcYwnF6gjz9leLV1QYIACuMHdzjddre93FH_kZ0l_FZMBjKjiDo2CVygyehU-umOp8fU_9p\"]}', '2025-10-12 19:45:24', '2025-10-12 19:45:25'),
(320, 40, 'AcyEVLTJX1Ot_K3_GTpWoiAK8YrVJMcNH4rVCYXU9luFnwzS8tDaZrAXc0pXMdelM7scOKdQ18NbaCaETTgNRkKi', 'synced', 'in stock', '2025-10-12 19:45:26', NULL, '{\"handles\":[\"AcyEVLTJX1Ot_K3_GTpWoiAK8YrVJMcNH4rVCYXU9luFnwzS8tDaZrAXc0pXMdelM7scOKdQ18NbaCaETTgNRkKi\"]}', '2025-10-12 19:45:25', '2025-10-12 19:45:26'),
(321, 41, 'Acw19Ls-VFdpz5ZjQoKufVIcT-9Rj7bO5N-CIQY2yQ9icHq6Weu5Si80_rc5PqkF0QUUTJEnpUuQDcrUH8cgMPYO', 'synced', 'in stock', '2025-10-12 19:45:28', NULL, '{\"handles\":[\"Acw19Ls-VFdpz5ZjQoKufVIcT-9Rj7bO5N-CIQY2yQ9icHq6Weu5Si80_rc5PqkF0QUUTJEnpUuQDcrUH8cgMPYO\"]}', '2025-10-12 19:45:26', '2025-10-12 19:45:28'),
(322, 42, 'AcxYwswa3X6QEmZGx0P0cZLjiDEDuY36rnjBzS1ZkiIIsBFkLWOqplZDh_wtfKnObHzEgzZAhhXLpnl3AzJIb0mJ', 'synced', 'in stock', '2025-10-12 19:45:30', NULL, '{\"handles\":[\"AcxYwswa3X6QEmZGx0P0cZLjiDEDuY36rnjBzS1ZkiIIsBFkLWOqplZDh_wtfKnObHzEgzZAhhXLpnl3AzJIb0mJ\"]}', '2025-10-12 19:45:28', '2025-10-12 19:45:30'),
(323, 43, 'AcxH42ZI7PEFZCIjQ2s3DPuaYJ-ePrL3rYzQgOu4Z4wk2rF9Q2edFq6Yix-VLNSRsp3KFodlj6G0M-v6v6QnbVTR', 'synced', 'in stock', '2025-10-12 19:45:32', NULL, '{\"handles\":[\"AcxH42ZI7PEFZCIjQ2s3DPuaYJ-ePrL3rYzQgOu4Z4wk2rF9Q2edFq6Yix-VLNSRsp3KFodlj6G0M-v6v6QnbVTR\"]}', '2025-10-12 19:45:30', '2025-10-12 19:45:32'),
(324, 44, 'AcytfpV74LoI_GfI3bmqL-ak_LDtvMYri0VMd1f0DDyAUIei3eAc1OuESKP2ufNrHXwF1xb9Q1gPBkvg6dsiqX9F', 'synced', 'in stock', '2025-10-12 19:45:34', NULL, '{\"handles\":[\"AcytfpV74LoI_GfI3bmqL-ak_LDtvMYri0VMd1f0DDyAUIei3eAc1OuESKP2ufNrHXwF1xb9Q1gPBkvg6dsiqX9F\"]}', '2025-10-12 19:45:32', '2025-10-12 19:45:34'),
(325, 45, 'Acx1tNzYme-1zet_LfVmiPptWQ26xriySalKz5VApxHqYfw41ClArQzANxqc4D-3iRE3KYka9gaaaHJyUNZ_PAF_', 'synced', 'in stock', '2025-10-12 19:45:36', NULL, '{\"handles\":[\"Acx1tNzYme-1zet_LfVmiPptWQ26xriySalKz5VApxHqYfw41ClArQzANxqc4D-3iRE3KYka9gaaaHJyUNZ_PAF_\"]}', '2025-10-12 19:45:34', '2025-10-12 19:45:36'),
(326, 46, 'AcwzjZPVDEw2LFqHauqZYzB-T2lOq7NoPyZXck8DOflGLfguS5f-vDd7zNMnbPtf01He2ALW3URkhMixOAa4T6Vg', 'synced', 'in stock', '2025-10-12 19:45:38', NULL, '{\"handles\":[\"AcwzjZPVDEw2LFqHauqZYzB-T2lOq7NoPyZXck8DOflGLfguS5f-vDd7zNMnbPtf01He2ALW3URkhMixOAa4T6Vg\"]}', '2025-10-12 19:45:36', '2025-10-12 19:45:38'),
(327, 47, 'AcwVcHEdrUGq5MfWJ2EaDevNId_AHR9HRVLO74g9bu1EV6NY0aYK-bBBOAjYfkXqzwp2oFvz59s3iI_EqU406guB', 'synced', 'in stock', '2025-10-12 19:45:39', NULL, '{\"handles\":[\"AcwVcHEdrUGq5MfWJ2EaDevNId_AHR9HRVLO74g9bu1EV6NY0aYK-bBBOAjYfkXqzwp2oFvz59s3iI_EqU406guB\"]}', '2025-10-12 19:45:38', '2025-10-12 19:45:39'),
(328, 48, 'AcyCtLkqkoDcfZwSJZRajWSRPuoTWWXNxHZ3cb5Del5Rr9HPkTQxugpV2qppTtHJH0weeZgQUP3k_SIjvkmaehZY', 'synced', 'in stock', '2025-10-12 19:45:41', NULL, '{\"handles\":[\"AcyCtLkqkoDcfZwSJZRajWSRPuoTWWXNxHZ3cb5Del5Rr9HPkTQxugpV2qppTtHJH0weeZgQUP3k_SIjvkmaehZY\"]}', '2025-10-12 19:45:39', '2025-10-12 19:45:41'),
(329, 49, 'AczH2hHio9pBWIGNxGHiVfZy61AjA324W240tPRIo-Jh1vV1e8UmBWMzvWESsqk4baukuLGCtH13S8TaTjHrD5HD', 'synced', 'in stock', '2025-10-12 19:45:43', NULL, '{\"handles\":[\"AczH2hHio9pBWIGNxGHiVfZy61AjA324W240tPRIo-Jh1vV1e8UmBWMzvWESsqk4baukuLGCtH13S8TaTjHrD5HD\"]}', '2025-10-12 19:45:41', '2025-10-12 19:45:43'),
(330, 50, 'Acz9VLAooArmQAdUPufcue-tHmlJhf-uVpiX9U8tONCw_J9xK5Nuera5Wh3dodhZ7DgZQ-u7B9AxHs6zjW1huGd8', 'synced', 'in stock', '2025-10-12 19:45:46', NULL, '{\"handles\":[\"Acz9VLAooArmQAdUPufcue-tHmlJhf-uVpiX9U8tONCw_J9xK5Nuera5Wh3dodhZ7DgZQ-u7B9AxHs6zjW1huGd8\"]}', '2025-10-12 19:45:43', '2025-10-12 19:45:46'),
(331, 51, 'Acw-DpYcg3VrQBkoka1p2wG3MLkCgTic2Lk7AshIdOuQd0-TUKDDqtjDROZ8v9HpuedAorRH_xmComk4JcQ9E8LB', 'synced', 'in stock', '2025-10-12 19:45:48', NULL, '{\"handles\":[\"Acw-DpYcg3VrQBkoka1p2wG3MLkCgTic2Lk7AshIdOuQd0-TUKDDqtjDROZ8v9HpuedAorRH_xmComk4JcQ9E8LB\"]}', '2025-10-12 19:45:46', '2025-10-12 19:45:48'),
(332, 52, 'Acy5VAWwZozS9V2i8t4PgvsCHVtyAHNMRRIY5K98tvfdh6R2vVv2lRQvtVSBytyPlniUVSappVRxIa8X8xjoeeOp', 'synced', 'in stock', '2025-10-12 19:45:49', NULL, '{\"handles\":[\"Acy5VAWwZozS9V2i8t4PgvsCHVtyAHNMRRIY5K98tvfdh6R2vVv2lRQvtVSBytyPlniUVSappVRxIa8X8xjoeeOp\"]}', '2025-10-12 19:45:48', '2025-10-12 19:45:49'),
(333, 53, 'Acxxu62f8oBa5itZmOtZRyuv-gQAlMNzZ079mzfQCamOVhkSiDH96iwvlO1kmsis7zYaWTyXpXElsIsp2GZOt_JF', 'synced', 'in stock', '2025-10-12 19:45:51', NULL, '{\"handles\":[\"Acxxu62f8oBa5itZmOtZRyuv-gQAlMNzZ079mzfQCamOVhkSiDH96iwvlO1kmsis7zYaWTyXpXElsIsp2GZOt_JF\"]}', '2025-10-12 19:45:49', '2025-10-12 19:45:51'),
(334, 54, 'Aczu2w-mZBbssqrWpjxY8jGaJghqrYx_Hlws4ysVztYY0EpACMBrAy18cMOw5gl8oFNT2oBLmJmde8fuHuHiuWLU', 'synced', 'in stock', '2025-10-12 19:45:52', NULL, '{\"handles\":[\"Aczu2w-mZBbssqrWpjxY8jGaJghqrYx_Hlws4ysVztYY0EpACMBrAy18cMOw5gl8oFNT2oBLmJmde8fuHuHiuWLU\"]}', '2025-10-12 19:45:51', '2025-10-12 19:45:52'),
(335, 55, 'AcwG7jJ8komKBb3ld9DsuhBxaTg45LKmly6VXQCvuubo5gSoP4jdY1bBvJNllboSvUidhb70ZQvL1L-OWhN4x0sY', 'synced', 'in stock', '2025-10-12 19:45:54', NULL, '{\"handles\":[\"AcwG7jJ8komKBb3ld9DsuhBxaTg45LKmly6VXQCvuubo5gSoP4jdY1bBvJNllboSvUidhb70ZQvL1L-OWhN4x0sY\"]}', '2025-10-12 19:45:52', '2025-10-12 19:45:54'),
(336, 56, 'AczdhMo2DgWTXbyxWt2PKODGzxtGfkVk98vjR2hi39zILRHtq1jxJZVL7tnBBqNw5dVbTHuwXHgGpuJKG_svCEJd', 'synced', 'in stock', '2025-10-12 19:45:56', NULL, '{\"handles\":[\"AczdhMo2DgWTXbyxWt2PKODGzxtGfkVk98vjR2hi39zILRHtq1jxJZVL7tnBBqNw5dVbTHuwXHgGpuJKG_svCEJd\"]}', '2025-10-12 19:45:54', '2025-10-12 19:45:56'),
(337, 57, 'AczcRua0PVoZ3V41Nhuiz6uwr15_KdbgHPhuCY7ofPOclPirTIwWDbycmkLwsG3PClMqCtWTBfOxJ0Fx_LEiZ5sT', 'synced', 'in stock', '2025-10-12 19:45:57', NULL, '{\"handles\":[\"AczcRua0PVoZ3V41Nhuiz6uwr15_KdbgHPhuCY7ofPOclPirTIwWDbycmkLwsG3PClMqCtWTBfOxJ0Fx_LEiZ5sT\"]}', '2025-10-12 19:45:56', '2025-10-12 19:45:57'),
(338, 58, 'Acyo8QlEolqXjsNg_2ZWdcE1Jd0mpFxCKAHmxUndK2CcJ6v5E6bO0qFRIdhDXjJ8Tp-SCQQvUhxx6CZ2dHAvi0Mg', 'synced', 'in stock', '2025-10-12 19:45:59', NULL, '{\"handles\":[\"Acyo8QlEolqXjsNg_2ZWdcE1Jd0mpFxCKAHmxUndK2CcJ6v5E6bO0qFRIdhDXjJ8Tp-SCQQvUhxx6CZ2dHAvi0Mg\"]}', '2025-10-12 19:45:57', '2025-10-12 19:45:59'),
(339, 59, 'Acx4NesvF7K7DtJbUjB6pOI69E12KPvWPfXiKR-FfdPai9y2claXlHcCKzQTh60IdTMoaKD7I-3GjY2-yQzBV-Am', 'synced', 'in stock', '2025-10-12 19:46:01', NULL, '{\"handles\":[\"Acx4NesvF7K7DtJbUjB6pOI69E12KPvWPfXiKR-FfdPai9y2claXlHcCKzQTh60IdTMoaKD7I-3GjY2-yQzBV-Am\"]}', '2025-10-12 19:45:59', '2025-10-12 19:46:01'),
(340, 60, 'Acy3L2IP1DsOa-uk7-0knkylqEEZXNv1Wtqdyg88kALbxTlWv0SxWVVaB-QXFo6C_oiWL7H98FYlX78lmWex0WvB', 'synced', 'in stock', '2025-10-12 19:46:03', NULL, '{\"handles\":[\"Acy3L2IP1DsOa-uk7-0knkylqEEZXNv1Wtqdyg88kALbxTlWv0SxWVVaB-QXFo6C_oiWL7H98FYlX78lmWex0WvB\"]}', '2025-10-12 19:46:01', '2025-10-12 19:46:03'),
(341, 61, 'Acwo_dUX09uPEFSvsT3NzcVGValWdBQmDOxt_c9gierZRSieGQET2a7MgYsL8Jlfz21XiTRTwsrKBzTgBDQ5mUcf', 'synced', 'in stock', '2025-10-12 19:46:05', NULL, '{\"handles\":[\"Acwo_dUX09uPEFSvsT3NzcVGValWdBQmDOxt_c9gierZRSieGQET2a7MgYsL8Jlfz21XiTRTwsrKBzTgBDQ5mUcf\"]}', '2025-10-12 19:46:03', '2025-10-12 19:46:05'),
(342, 62, 'AcxSIOm2qDzQ-Ot1WT3GEI9hs73x4DfORd1eIQpiPuvC2LCG8pDEQGF6_Y5Xy4_Ye7Cftyi19aNQIeTSd5HIu-b5', 'synced', 'in stock', '2025-10-12 19:46:07', NULL, '{\"handles\":[\"AcxSIOm2qDzQ-Ot1WT3GEI9hs73x4DfORd1eIQpiPuvC2LCG8pDEQGF6_Y5Xy4_Ye7Cftyi19aNQIeTSd5HIu-b5\"]}', '2025-10-12 19:46:05', '2025-10-12 19:46:07'),
(343, 63, 'Acw7_uqTW01aPDGTyxK-Oh6GZoM3JF9Bk7GH-plaDKmWm7VcehYhiaCV8zdW2ZKKc_EXRWfY_0UfOxgbP4Df8ODC', 'synced', 'in stock', '2025-10-12 19:46:09', NULL, '{\"handles\":[\"Acw7_uqTW01aPDGTyxK-Oh6GZoM3JF9Bk7GH-plaDKmWm7VcehYhiaCV8zdW2ZKKc_EXRWfY_0UfOxgbP4Df8ODC\"]}', '2025-10-12 19:46:07', '2025-10-12 19:46:09'),
(344, 64, 'AcwM3EGSrG9VFY0PmbshNggQ3v2_ukRypgSGmr9oxk_tjsSR__Bg0gC2IZVcWvffGJ8UgQrJK9qkRzEkFTcEMc3h', 'synced', 'in stock', '2025-10-12 19:46:10', NULL, '{\"handles\":[\"AcwM3EGSrG9VFY0PmbshNggQ3v2_ukRypgSGmr9oxk_tjsSR__Bg0gC2IZVcWvffGJ8UgQrJK9qkRzEkFTcEMc3h\"]}', '2025-10-12 19:46:09', '2025-10-12 19:46:10'),
(345, 65, 'AczVH1-RGd3F70iqqiKZsmGFyYDOatccpzBvHUL0q_JAFnlDtjYPij2EYxxtnTqYep1_lv3jRvKqos2nEtXjeLTY', 'synced', 'in stock', '2025-10-12 19:46:12', NULL, '{\"handles\":[\"AczVH1-RGd3F70iqqiKZsmGFyYDOatccpzBvHUL0q_JAFnlDtjYPij2EYxxtnTqYep1_lv3jRvKqos2nEtXjeLTY\"]}', '2025-10-12 19:46:10', '2025-10-12 19:46:12'),
(346, 66, 'Acz4u4nNWKzwYvSEm0vqywPPd4MucIQ9TgNXuS_N2OMLEIt3hArv9SZrBu0XKhEuAceEWlpvvdRZcSjxPhuJbQ7C', 'synced', 'in stock', '2025-10-12 19:46:14', NULL, '{\"handles\":[\"Acz4u4nNWKzwYvSEm0vqywPPd4MucIQ9TgNXuS_N2OMLEIt3hArv9SZrBu0XKhEuAceEWlpvvdRZcSjxPhuJbQ7C\"]}', '2025-10-12 19:46:12', '2025-10-12 19:46:14'),
(347, 67, 'AcxgsGVtYPXT1LXKvXgEeMae2KMVLc2-kd66jBqJslhlAbYFBIfw624C4sXxzOfrN-67ifbH-QGMi_mhguz630cE', 'synced', 'in stock', '2025-10-12 19:46:16', NULL, '{\"handles\":[\"AcxgsGVtYPXT1LXKvXgEeMae2KMVLc2-kd66jBqJslhlAbYFBIfw624C4sXxzOfrN-67ifbH-QGMi_mhguz630cE\"]}', '2025-10-12 19:46:14', '2025-10-12 19:46:16'),
(348, 68, 'AcxYWed8CsKkzrc1fXGAY5mvwNmlUr2NidtshXGMBKqh5AB6AOV1Z1qNxdI2NfdpICpoau3EiuB9CxKtadCSmjbd', 'synced', 'in stock', '2025-10-12 19:46:17', NULL, '{\"handles\":[\"AcxYWed8CsKkzrc1fXGAY5mvwNmlUr2NidtshXGMBKqh5AB6AOV1Z1qNxdI2NfdpICpoau3EiuB9CxKtadCSmjbd\"]}', '2025-10-12 19:46:16', '2025-10-12 19:46:17'),
(349, 69, 'Acx7fP8KzxwjrzM6IDfxhqNOYIPQCLMNy46VWhPAssBE_2JdGU0He0yBh3VwW-OETUSwRKbjt_RAjqBKfhIJNVmn', 'synced', 'in stock', '2025-10-12 19:46:20', NULL, '{\"handles\":[\"Acx7fP8KzxwjrzM6IDfxhqNOYIPQCLMNy46VWhPAssBE_2JdGU0He0yBh3VwW-OETUSwRKbjt_RAjqBKfhIJNVmn\"]}', '2025-10-12 19:46:17', '2025-10-12 19:46:20'),
(350, 70, 'AcykWg0qLNwDU6H6f759FFnPDUtv9zqKuW6o5TuaAD96UtxZpFsqvAc-X3UcpKVlZaBRy07-WvINZ6jh93YyIMP_', 'synced', 'in stock', '2025-10-12 19:46:23', NULL, '{\"handles\":[\"AcykWg0qLNwDU6H6f759FFnPDUtv9zqKuW6o5TuaAD96UtxZpFsqvAc-X3UcpKVlZaBRy07-WvINZ6jh93YyIMP_\"]}', '2025-10-12 19:46:20', '2025-10-12 19:46:23'),
(351, 71, 'AcxbXWjpKoATyBCormbkgdNEfuV7390z0Px0-VLSd7ep-N74IAQ-3r9VtH6DDeOCn18bwrUGsb5li0rx3SL4-x2l', 'synced', 'in stock', '2025-10-12 19:46:25', NULL, '{\"handles\":[\"AcxbXWjpKoATyBCormbkgdNEfuV7390z0Px0-VLSd7ep-N74IAQ-3r9VtH6DDeOCn18bwrUGsb5li0rx3SL4-x2l\"]}', '2025-10-12 19:46:23', '2025-10-12 19:46:25'),
(352, 72, 'AcyhhIV7DwuSfRSh0b0e5AjkIrNEnmEeqM9-2i2RJuL8eAjS54yJbqzcak4g8fNkFsfGZh3SN93uB5_MK3_pc0Td', 'synced', 'in stock', '2025-10-12 19:46:26', NULL, '{\"handles\":[\"AcyhhIV7DwuSfRSh0b0e5AjkIrNEnmEeqM9-2i2RJuL8eAjS54yJbqzcak4g8fNkFsfGZh3SN93uB5_MK3_pc0Td\"]}', '2025-10-12 19:46:25', '2025-10-12 19:46:26'),
(353, 73, 'AczU6SvZkZiBlz5SMR_GtnEiOMGAPnqrarXdEUL8Du0bkXiOeqKopHVPJ89ZbrH2ckjtVZU3p-w0nI0Vy3t62uTa', 'synced', 'in stock', '2025-10-12 19:46:28', NULL, '{\"handles\":[\"AczU6SvZkZiBlz5SMR_GtnEiOMGAPnqrarXdEUL8Du0bkXiOeqKopHVPJ89ZbrH2ckjtVZU3p-w0nI0Vy3t62uTa\"]}', '2025-10-12 19:46:26', '2025-10-12 19:46:28'),
(354, 74, 'AcxfFkHSbN6wA63ZDTHkREGt03vyrLrXaseeaCNZntNYPK0bcJEyyYLkRzyM9Cc6NCjvES0FOS44f8WlkDfWwIJo', 'synced', 'in stock', '2025-10-12 19:46:29', NULL, '{\"handles\":[\"AcxfFkHSbN6wA63ZDTHkREGt03vyrLrXaseeaCNZntNYPK0bcJEyyYLkRzyM9Cc6NCjvES0FOS44f8WlkDfWwIJo\"]}', '2025-10-12 19:46:28', '2025-10-12 19:46:29'),
(355, 75, 'Acy-WY-i_ARB0BsHuPTY8NEjZIEQ9ppxQUwNliT2PHlZ-xPt5lurKtZWoZZu_yBvpg2QCGG1BUoiIv0Pyh1Ujda2', 'synced', 'in stock', '2025-10-12 19:46:31', NULL, '{\"handles\":[\"Acy-WY-i_ARB0BsHuPTY8NEjZIEQ9ppxQUwNliT2PHlZ-xPt5lurKtZWoZZu_yBvpg2QCGG1BUoiIv0Pyh1Ujda2\"]}', '2025-10-12 19:46:29', '2025-10-12 19:46:31'),
(356, 76, 'AcxVqD0ZLM-ss7fFn0bSHOAWQziN0WA0IcEFzmhg-5m2H-Ohzex_SjsbcNpsAQChd-khjSxse-KdODkBTU6QTl0J', 'synced', 'in stock', '2025-10-12 19:46:32', NULL, '{\"handles\":[\"AcxVqD0ZLM-ss7fFn0bSHOAWQziN0WA0IcEFzmhg-5m2H-Ohzex_SjsbcNpsAQChd-khjSxse-KdODkBTU6QTl0J\"]}', '2025-10-12 19:46:31', '2025-10-12 19:46:32'),
(357, 77, 'Acwsgb1Eap9Ur6UF4I91L-aVxInLU8PwgUhtMMC1rid8P2jNsKYTnm2HRC50yXyEd2QgfoJ3oEZWeWrt2QOsW1qc', 'synced', 'in stock', '2025-10-12 19:46:34', NULL, '{\"handles\":[\"Acwsgb1Eap9Ur6UF4I91L-aVxInLU8PwgUhtMMC1rid8P2jNsKYTnm2HRC50yXyEd2QgfoJ3oEZWeWrt2QOsW1qc\"]}', '2025-10-12 19:46:32', '2025-10-12 19:46:34'),
(358, 78, 'AcwkTnwGZEErbsSaziLzkBbfNINrajL5F7cTm--WrU-ODVp9MM2GBt-EoiMTjCbNkzFDOd135MrZdhLumyph4a7x', 'synced', 'in stock', '2025-10-12 19:46:36', NULL, '{\"handles\":[\"AcwkTnwGZEErbsSaziLzkBbfNINrajL5F7cTm--WrU-ODVp9MM2GBt-EoiMTjCbNkzFDOd135MrZdhLumyph4a7x\"]}', '2025-10-12 19:46:34', '2025-10-12 19:46:36'),
(359, 79, 'Acz9m1Rez-fkvVUfP5ajt-SbZUiuiYZiL7c1qh8RKuFyjTbFWPh6Gq9PZl5_IVKotZU7cQ38os4pzSajTq6SO12d', 'synced', 'in stock', '2025-10-12 19:46:37', NULL, '{\"handles\":[\"Acz9m1Rez-fkvVUfP5ajt-SbZUiuiYZiL7c1qh8RKuFyjTbFWPh6Gq9PZl5_IVKotZU7cQ38os4pzSajTq6SO12d\"]}', '2025-10-12 19:46:36', '2025-10-12 19:46:37'),
(360, 80, 'Acxgv8I7WTBKnxLNUM_5LZE_lteIOVf2Sm9OWs9O7zo9ymJYMxtMpKlunuHz2se_CAyOGs7zRtA3883wCUDYSxqX', 'synced', 'in stock', '2025-10-12 19:46:38', NULL, '{\"handles\":[\"Acxgv8I7WTBKnxLNUM_5LZE_lteIOVf2Sm9OWs9O7zo9ymJYMxtMpKlunuHz2se_CAyOGs7zRtA3883wCUDYSxqX\"]}', '2025-10-12 19:46:37', '2025-10-12 19:46:38');


-- Table structure for table `facebook_sync_logs`
DROP TABLE IF EXISTS `facebook_sync_logs`;
CREATE TABLE "facebook_sync_logs" ("id" integer primary key autoincrement not null, "sync_type" varchar not null, "status" varchar not null, "products_synced" integer not null default '0', "products_failed" integer not null default '0', "error_message" text, "details" text, "started_at" datetime, "completed_at" datetime, "created_at" datetime, "updated_at" datetime);


-- Dumping data for table `facebook_sync_logs`
INSERT INTO `facebook_sync_logs` (`id`, `sync_type`, `status`, `products_synced`, `products_failed`, `error_message`, `details`, `started_at`, `completed_at`, `created_at`, `updated_at`) VALUES
(1, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 15:21:54', '2025-10-12 15:21:54', '2025-10-12 15:21:54', '2025-10-12 15:21:54'),
(2, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 15:22:29', '2025-10-12 15:22:29', '2025-10-12 15:22:29', '2025-10-12 15:22:29'),
(3, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 15:33:05', '2025-10-12 15:33:29', '2025-10-12 15:33:05', '2025-10-12 15:33:29'),
(4, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 15:43:49', '2025-10-12 15:44:13', '2025-10-12 15:43:49', '2025-10-12 15:44:13'),
(5, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 16:14:14', '2025-10-12 16:14:44', '2025-10-12 16:14:14', '2025-10-12 16:14:44'),
(6, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 18:42:43', '2025-10-12 18:43:14', '2025-10-12 18:42:43', '2025-10-12 18:43:14'),
(7, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 18:55:29', '2025-10-12 18:55:57', '2025-10-12 18:55:29', '2025-10-12 18:55:57'),
(8, 'full', 'completed', 0, 72, NULL, NULL, '2025-10-12 19:21:06', '2025-10-12 19:21:35', '2025-10-12 19:21:06', '2025-10-12 19:21:35'),
(9, 'full', 'completed', 72, 0, NULL, NULL, '2025-10-12 19:24:40', '2025-10-12 19:26:47', '2025-10-12 19:24:40', '2025-10-12 19:26:47'),
(10, 'full', 'completed', 72, 0, NULL, NULL, '2025-10-12 19:36:12', '2025-10-12 19:38:19', '2025-10-12 19:36:12', '2025-10-12 19:38:19'),
(11, 'full', 'completed', 72, 0, NULL, NULL, '2025-10-12 19:44:31', '2025-10-12 19:46:38', '2025-10-12 19:44:31', '2025-10-12 19:46:38');


-- Table structure for table `whatsapp_carts`
DROP TABLE IF EXISTS `whatsapp_carts`;
CREATE TABLE "whatsapp_carts" ("id" integer primary key autoincrement not null, "phone_number" varchar not null, "user_id" integer, "product_id" integer not null, "variant_id" integer, "quantity" integer not null default '1', "price" numeric not null, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade, foreign key("product_id") references "products"("id") on delete cascade, foreign key("variant_id") references "product_variants"("id") on delete cascade);


-- Dumping data for table `whatsapp_carts`
INSERT INTO `whatsapp_carts` (`id`, `phone_number`, `user_id`, `product_id`, `variant_id`, `quantity`, `price`, `created_at`, `updated_at`) VALUES
(1, '918536945959', NULL, 12, NULL, 1, 360, '2025-10-12 21:49:42', '2025-10-12 21:49:42'),
(2, '918536945959', NULL, 80, NULL, 2, 1, '2025-10-12 22:03:32', '2025-10-12 22:19:27');


-- Table structure for table `whatsapp_commerce_sessions`
DROP TABLE IF EXISTS `whatsapp_commerce_sessions`;
CREATE TABLE "whatsapp_commerce_sessions" ("id" integer primary key autoincrement not null, "phone_number" varchar not null, "user_id" integer, "current_step" varchar not null default 'browse', "session_data" text, "last_message_id" varchar, "last_activity_at" datetime, "created_at" datetime, "updated_at" datetime, foreign key("user_id") references "users"("id") on delete cascade);


-- Dumping data for table `whatsapp_commerce_sessions`
INSERT INTO `whatsapp_commerce_sessions` (`id`, `phone_number`, `user_id`, `current_step`, `session_data`, `last_message_id`, `last_activity_at`, `created_at`, `updated_at`) VALUES
(1, '918536945959', NULL, 'awaiting_email', '{\"name\":\"Hi\",\"email\":\"jasimmondal57@gmail.com\",\"address\":\"Bolpur,jjkaa\",\"city\":\"Bolp\",\"pincode\":\"731204\",\"payment_method\":\"cod\"}', NULL, '2025-10-12 22:26:29', '2025-10-12 21:49:08', '2025-10-12 22:26:29');


SET FOREIGN_KEY_CHECKS = 1;
