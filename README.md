# How to install Zerobug 8
## Install docker
 Link download [Docker Desktop](https://www.docker.com/products/docker-desktop)
	
## Install Zerobug
1. Init docker-compose
    Vào thư mục `Zerobug8\docker-compose`
    shift + chuột phải chọn `open PowerShell Windows here`
    chạy lệnh cài đặt (1): 
    ```bash
        docker-compose up -d
    ```
2. Make env file
    Ra thư mục root `Zerobug8/` (2):
    copy `.env.example` thành `.env`
    
3. Composer install
    - chờ bước (1) + (2) chạy xong. Thì cài đặt vendor (trong PowerShell Window):
        ```bash
        docker exec zerobug_nginx composer install
        docker exec zerobug_nginx php artisan key:generate 
        ```
    - Add thêm vào file hosts trong windows: `C:\Windows\System32\drivers\etc`: 
    ```bash
        127.0.0.1 zerobug.local www.zerobug.local
    ```
    
4. Connect DB (Optional):
    ```bash
    DB_HOST=127.0.0.1
    DB_PORT=3308
    DB USER/PW: root/vinhvv@123
    ```

5. Migrate database
    ```bash
    docker exec zerobug_nginx php artisan migrate
    ```
6. Passport install
    ```bash
    docker exec zerobug_nginx php artisan passport:install
    ```
    Sau bước này sẽ generate ra 2 files trong thư mục `Zerobug8\storage`: oauth-private.key, oauth-public.key
    Copy nội dung 2 file này, thay vào các phần tương ứng trong .env: PASSPORT_PRIVATE_KEY, PASSPORT_PUBLIC_KEY
    CHÚ Ý: nội dung trong 2 file sẽ nằm trong hai dấu `""`
    
    Clear cache:
    ```bash
    docker exec zerobug_nginx php artisan cache:clear
    ```

7. Make data
    ```bash
    docker exec zerobug_nginx php artisan db:seed
    ```
8. Creating A Password Grant Client (8)
    ```bash
    docker exec zerobug_nginx php artisan passport:client --password
    ```

    Chú ý lưu lại client id + secret của Client ở bước này. Nếu skip, thì cần phải vào database để lấy lại.
    ID/Secret sẽ sử dụng để request token trên postman.
    
9. Access
    [Zerobug URL](http://www.zerobug.local)
   - Account login: `admin@gmail.com/abcd1234`

# Postman

- Import Zerobug Collection from file:
 
    > `Zerobug8\Zerobug API Demo.postman_collection.json`

- Sử dụng ID/Secret ở bước (8), update vào environment của Zerobug collection.

- Truy cập link [zeroblog.net](https://www.zeroblog.net/2021/08/api-testing-va-hon-the.html) để thực hành sử dụng postman test api.
	
* Import collection:
    > `http://www.zerobug.local/docs/api-docs.json`

* Tạo biến Enviroment trước, sau đó tạo url getToken, sau khi get Token xong update lại các biến access_token, refresh_token, ExpiresInTime lại vào chỗ biến Enviroment.

* Khi call api cần fill Access Token vào Authorization mới có thể call được.