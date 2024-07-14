# Tweet Application

---

## Proje İsterleri

Proje'de bulunması gerekenler:

- Kullanıcılar bir kullanıcı adı ve şifresi ile uygulamaya kayıt olabilir.
- Kayıtlı kullanıcıların bir profil sayfası olur.
- Kayıtlı kullanıcılar 180 karakterlik tweet paylaşabilir.
- Kayıtlı olmayan kullanıcılar tweet okuyamaz.
- Son gönderilen tweet sayfanın başında gösterilir.
- Üyeler birbirlerine takip isteği gönderebilir. Takip isteği alan kişi kabul/ret edebilir.
- Arkadaş olmuş kullanıcılar birbirlerinin sayfasına girerek tweetlerini okuyabilir.
- Anasayfada arkadaşlarının tweetlerini son gönderilen en üstte olacak şekilde görür.
- Kayıtlı olmayan kullanıcılar tweet okuyabilir ama tweet atamaz.
- Son gönderilen tweet sayfanın başında gösterilir.

Proje linki: [Patika Dev PHP TweetApp](https://academy.patika.dev/tr/courses/php-ile-backend-patikasi-projeleri/php-proje-tweet-advanced)

## Kullanılan Teknolojiler

- PHP
- MySQL
- Bootstrap
- SweetAlert
- HTML
- CSS
- JavaScript

## Proje Özeti

Bu proje, kullanıcıların bir sosyal medya platformu benzeri bir ortamda kısa mesajlar (tweetler) paylaşmalarına olanak tanır. Kullanıcılar uygulamaya kayıt olabilir, giriş yapabilir, tweet paylaşabilir ve diğer kullanıcılarla etkileşimde bulunabilirler. Kayıtlı kullanıcılar profil sayfalarına sahip olup, diğer kullanıcıları takip edebilir ve takip istekleri alabilirler. Takip istekleri kabul edildiğinde, kullanıcılar birbirlerinin tweetlerini görebilirler. Ana sayfada, kullanıcının takip ettiği kişilerin en son gönderdiği tweetler gösterilir.

## SQL Tabloları

```sql
CREATE TABLE `users` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `username` varchar(50) NOT NULL,
    `password` varchar(255) NOT NULL,
    `email` varchar(100) DEFAULT NULL,
    `birthday` date DEFAULT NULL,
    PRIMARY KEY (`id`)
);

CREATE TABLE `tweets` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `user_id` int(11) NOT NULL,
    `tweet` text NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`user_id`) REFERENCES `users`(`id`)
);

CREATE TABLE follow_requests (
    id INT AUTO_INCREMENT PRIMARY KEY,
    sender_id INT NOT NULL,
    receiver_id INT NOT NULL,
    status ENUM('pending', 'accepted', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (receiver_id) REFERENCES users(id)
);

CREATE TABLE notifications (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    sender_id INT NOT NULL,
    message VARCHAR(255) NOT NULL,
    status ENUM('unread', 'read') DEFAULT 'unread',
    follow_request_id INT,
    type ENUM('follow_request', 'other') DEFAULT 'follow_request',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (sender_id) REFERENCES users(id),
    FOREIGN KEY (follow_request_id) REFERENCES follow_requests(id)
);

CREATE TABLE `followers` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
    `sender_id` int(11) NOT NULL,
    `receiver_id` int(11) NOT NULL,
    `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (`id`),
    FOREIGN KEY (`sender_id`) REFERENCES `users`(`id`),
    FOREIGN KEY (`receiver_id`) REFERENCES `users`(`id`)
);
```

---

## Projeden Görseller

![login](img\login.png)

![register](img\register.png)

![homepage](img\homepage.png)

![tweet](img\tweet.png)

![profile](img\profile.png)

![yprofile](img\yprofile.png)