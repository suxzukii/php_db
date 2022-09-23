# php_db
チャットアプリ
1．環境情報
PHP 7.3.29
mysql 5.7.26
アプリケーションに使用するマスターデータ作成用のクエリを以下に記載しました。

２．注意事項
chat.phpのindex.php両ファイルにfunction connectDB()にDB接続情報の記載を適宜御指針の完了に合わせてください。



以下作成中に積み残した課題

１　カラムにオートインクリメントを付与した場合
　phonyadminからはinsert成功したが
　webアプリケーションからはnsert失敗した
→原因はわからなかった為オートインクリメント付けないように仕様変更し対応した

２　fetchで取得されたデータが自動的にdistinctされ重複したものは一つにまとめられて表示された。
→原因と対策方法は不明。チャット画面messageは同じ文字列の場合表示がされないように見える。

○ ３　チャット画面にてユーザー識別番号をuserテーブルとテーブル結合しnameの取得ができていない
→２０２２０９２３実装完了

４　ログイン画面チャット画面にてSQLインジェクション対策できていない　ß

５　ソースコード　冗長　

６　セッションの利用ー＞セッションの値からパラメータの取得しユーザーの判別がしたい

７　パスワードのハッシュ化する処理について平文のまま使用した。→機能を落として対応




-- phpMyAdmin SQL Dump
-- version 4.9.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Aug 29, 2022 at 12:08 PM
-- Server version: 5.7.26
-- PHP Version: 7.4.2

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `pbboard2022`
--

-- --------------------------------------------------------

--
-- Table structure for table `sample`
--

CREATE TABLE `sample` (
  `user_no_from` varchar(255) NOT NULL,
  `user_no_to` varchar(255) NOT NULL,
  `message` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `sample`
--

INSERT INTO `sample` (`user_no_from`, `user_no_to`, `message`) VALUES
('1', '2', 'こんにちは'),
('2', '1', 'チワッス！'),
('1', '2', 'こんばんは'),
('1', '2', 'こんばん'),
('1', '2', 'こんば'),
('1', '2', 'こん'),
('1', '2', 'こ'),
('1', '2', 'コ'),
('1', '2', 'コン'),
('1', '2', 'コンチ'),
('1', '2', 'コンニチ'),
('2', '1', 'コンニチワ');

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `user_no` int(8) NOT NULL,
  `sign_in_id` varchar(8) NOT NULL,
  `password` varchar(8) NOT NULL,
  `name` varchar(15) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`user_no`, `sign_in_id`, `password`, `name`) VALUES
(1, '1234', '12345678', 'お米食べたい'),
(2, '5678', '1234', 'お花見したい');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_no`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `user_no` int(8) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;


