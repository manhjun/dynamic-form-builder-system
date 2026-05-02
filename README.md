# Form Management API

Hệ thống quản lý form động, cho phép admin tạo form với nhiều loại field khác nhau và nhân viên có thể điền form theo đúng thứ tự.

## Kiến Trúc & Quyết Định Thiết Kế

### Tại sao dùng Form Versioning?

Mỗi lần field trong form thay đổi, hệ thống tạo một `form_version` mới thay vì sửa trực tiếp. Điều này đảm bảo:

- Các submission cũ luôn giữ nguyên ngữ nghĩa — biết chính xác field nào, label gì tại thời điểm submit
- Không cần snapshot riêng cho `submission_values` vì versioning đã đóng vai trò đó
- Dễ audit và rollback

```
forms
└── form_versions (draft → active → archived)
└── fields
submissions → form_version_id
└── submission_values → field_id
```

### Field Type Registry Pattern

Thay vì dùng `enum` cố định cho `type`, hệ thống dùng Registry Pattern:

- Mỗi type là một class riêng, tự định nghĩa validation rules
- Thêm custom type chỉ cần tạo class mới + đăng ký trong `AppServiceProvider`
- Không cần sửa code cũ khi mở rộng

### Layer Architecture

```
Request → FormRequest → Controller → Service → Repository → Model
↓
FieldTypeRegistry
↓
FormValidator
```

## API Endpoints

### Form Management

| Method | Endpoint         | Mô tả                            |
| ------ | ---------------- | -------------------------------- |
| GET    | `/api/forms`     | Lấy danh sách tất cả form        |
| POST   | `/api/forms`     | Tạo form mới                     |
| GET    | `/api/forms/:id` | Lấy chi tiết 1 form (kèm fields) |
| PUT    | `/api/forms/:id` | Cập nhật thông tin form          |
| DELETE | `/api/forms/:id` | Xóa form                         |

### Field Management

| Method | Endpoint                     | Mô tả                            |
| ------ | ---------------------------- | -------------------------------- |
| POST   | `/api/forms/:id/fields`      | Thêm field vào form              |
| PUT    | `/api/forms/:id/fields/:fid` | Cập nhật field (tạo version mới) |
| DELETE | `/api/forms/:id/fields/:fid` | Xóa field                        |

### Submission

| Method | Endpoint                | Mô tả                    |
| ------ | ----------------------- | ------------------------ |
| GET    | `/api/forms/active`     | Danh sách form active    |
| POST   | `/api/forms/:id/submit` | Submit form              |
| GET    | `/api/submissions`      | Xem danh sách submission |

## Supported Field Types

| Type             | Mô tả             | Validation hỗ trợ                         |
| ---------------- | ----------------- | ----------------------------------------- |
| `text`           | Ô nhập văn bản    | `min`, `max`                              |
| `number`         | Ô nhập số         | `min`, `max`, `integer`                   |
| `date`           | Chọn ngày         | `no_past`, `no_future`, `after`, `before` |
| `datetime-local` | Chọn ngày giờ     | `after`, `before`                         |
| `color`          | Chọn màu          | HEX format `#RRGGBB`                      |
| `select`         | Dropdown          | `options`                                 |
| `checkbox`       | Checkbox          | -                                         |
| `radio`          | Radio button      | `options`                                 |
| `email`          | Email             | format email                              |
| `url`            | URL               | format url                                |
| `tel`            | Số điện thoại     | `regex`                                   |
| `file`           | Upload file       | `mimes`, `max`                            |
| `range`          | Thanh kéo         | `min`, `max`                              |
| `textarea`       | Ô nhập nhiều dòng | `min`, `max`                              |

### Thêm Custom Type

```php
// 1. Tạo class
class RichTextField extends BaseFieldType
{
    public function getType(): string { return 'richtext'; }

    public function buildRules(array $validation, bool $required): array
    {
        return [...$this->baseRules($required), 'string'];
    }
}

// 2. Đăng ký trong RepositoryServiceProvider
$registry->register(new RichTextField());
```

## Setup Project

### Step 1: Setup Docker

- [Install docker](https://docs.docker.com/compose/install/)

```bash
cp .env.example .env
docker-compose build
docker-compose up -d
```

### Step 2: Setup Laravel

```bash
# Vào container
docker exec -it container_name bash

# Tạo storage folders nếu chưa có
mkdir -p storage/framework/{sessions,views,cache}

# Cài đặt dependencies
composer install

# Setup environment
cp .env.example .env
php artisan key:generate

# Chạy migration và seed
php artisan migrate
php artisan db:seed

# Phân quyền storage
chmod -R o+w storage/
```

### Step 3: Khi thay đổi config queue

```bash
docker-compose down
docker-compose build
docker-compose up -d

# Hoặc
supervisorctl restart all
```

## Nếu có thêm thời gian

- [ ] Unit test cho `FormValidator` và từng `FieldType`
- [ ] Swagger documentation
- [ ] Pagination cho `GET /api/forms` và `GET /api/submissions`
- [ ] API reorder fields
