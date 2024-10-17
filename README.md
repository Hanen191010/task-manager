## نظام API متقدم لإدارة المهام

نظرة عامة:

هذا المشروع هو نظام API مُصمم لإدارة المهام بشكل مُتقدم، يوفر ميزات تُسهل عملية إدارة المهام وتُحسّن أداء الفريق.

الميزات الرئيسية:

* إدارة أنواع مختلفة من المهام: يُمكن إنشاء مهام متنوعة مثل الأخطاء (Bug)، الميزات (Feature)، والتحسينات (Improvement).
* تبعيات المهام: يُمكن ربط المهام ببعضها البعض لإنشاء سلسلة من التبعيات، بحيث تُصبح حالة المهمة مُقفلة (Blocked) إذا كانت تعتمد على مهمة أخرى لم تُكتمل بعد. 
* إعادة تعيين تلقائي: عند إغلاق مهمة تُعتمد عليها مهام أخرى، يتم تلقائيًا تغيير حالة المهام المُعتمدة إلى مفتوحة (Open) إذا استوفت جميع الشروط.
* تحليل الأداء وإدارة المهام: 
    * يُمكن توليد تقارير يومية تُوضح حالة المهام المُنجزة، المُتأخرة، وغيرها من البيانات ذات الصلة.
    * يُمكن التحقق من المهام المُتأخرة أو المُقفلة بسبب التبعيات.
* حماية أمنية مُتقدمة:
    * JWT Authentication: يستخدم API مصادقة JWT لتوفير أمان عالٍ للبيانات.
    * Rate Limiting: يُمكن ضبط حد لمعدل الطلبات لحماية API من الهجمات مثل DDoS.
    * CSRF Protection: يُوفر API حماية ضد هجمات CSRF.
    * XSS and SQL Injection Protection: يوفر Laravel الحماية من هجمات XSS و SQL Injection.
    * Permission-based Authorization: يُمكن التحكم في صلاحيات المستخدمين، بحيث يمكنهم فقط القيام بالإجراءات التي لديهم الصلاحية لها.
* إدارة ملفات المرفقات: يُمكن للمستخدمين إرفاق ملفات بالمهام، مع إمكانية تشفير الملفات وتوفير ميزة للتحقق من الملفات المرفوعة.
* تحسين أداء قاعدة البيانات:
    * Caching: يُمكن تخزين المهام التي يتم البحث عنها بشكل متكرر لتسريع الاستجابات.
    * Database Indexing: يُمكن تحسين أداء استعلامات البحث والفلترة.
* معالجة الأخطاء:
    * يُمكن تسجيل جميع الأخطاء التي تحدث داخل النظام في جداول منفصلة وتحليلها لاحقًا.
* توثيق API:
    * توثيق شامل لـAPI باستخدام PostMan مع توفير نماذج طلبات وإجابات لكل نقطة API، وتوضيح تفاصيل المصادقة، الرسائل المحتملة للأخطاء، وشرح كيفية استخدام الفلاتر المتقدمة.

الاستخدام:

* يُمكن استخدام API لإدارة المهام في مختلف المجالات مثل تطوير البرامج، إدارة المشاريع، والعمل الجماعي.

التركيب:

1. Clone the repository:
    
    git clone https://github.com/Hanen191010/task-manager.git
    
2. Install dependencies:
    
    composer install
    
3. Create a new database:
    * Create a new database in your database server.
4. Update database credentials:
    * Open `.env` file and update the database credentials.
5. Run migrations:
    
    php artisan migrate
    
6. Run seeders:
    
    php artisan db:seed
    
7. Start the development server:
    
    php artisan serve
    
8. Access the API endpoints:
    * Use the provided Postman collection to test the API endpoints.
    * `POST /api/tasks`
    * `PUT /api/tasks/{id}/status`
    * `PUT /api/tasks/{id}/reassign`
    * `POST /api/tasks/{id}/comments`
    * `POST /api/tasks/{id}/attachments`
    * `GET /api/tasks/{id}`
    * `GET /api/tasks`
    * `POST /api/tasks/{id}/assign`
    * `GET /api/reports/daily-tasks`
    * `GET /api/tasks?status=Blocked`


