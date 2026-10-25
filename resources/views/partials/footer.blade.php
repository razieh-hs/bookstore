<footer class="footer">
    <div class="container">
        <div class="footer-grid">
            <div>
                <div class="footer-logo"><span class="icon">📚</span> کتابستان</div>
                <p>فروشگاه آنلاین کتاب با سیستم توصیه‌گر مبتنی بر یادگیری ماشین. اینجا هر کتابی که دوست داری، پیدا می‌کنی — حتی اون‌هایی که خودت هم نمی‌دونی دنبالشون هستی!</p>
                <div class="socials">
                    <a href="#" title="اینستاگرام">📷</a>
                    <a href="#" title="تلگرام">✈️</a>
                    <a href="#" title="توییتر">🐦</a>
                    <a href="#" title="یوتیوب">▶️</a>
                </div>
            </div>
            <div>
                <h4>دسترسی سریع</h4>
                <ul>
                    <li><a href="{{ route('books.index') }}">همه کتاب‌ها</a></li>
                    <li><a href="{{ route('authors.index') }}">نویسندگان</a></li>
                    <li><a href="{{ route('recommendations.index') }}">پیشنهاد هوشمند</a></li>
                    <li><a href="{{ route('profile.index') }}">حساب کاربری</a></li>
                </ul>
            </div>
            <div>
                <h4>دسته‌بندی‌ها</h4>
                <ul>
                    <li><a href="{{ route('books.index') }}?genre=رمان">رمان</a></li>
                    <li><a href="{{ route('books.index') }}?genre=شعر">شعر</a></li>
                    <li><a href="{{ route('books.index') }}?genre=روانشناسی">روانشناسی</a></li>
                    <li><a href="{{ route('books.index') }}?genre=کودک و نوجوان">کودک و نوجوان</a></li>
                </ul>
            </div>
            <div>
                <h4>پشتیبانی</h4>
                <ul>
                    <li><a href="{{ route('support.index') }}">مرکز پشتیبانی</a></li>
                    <li><a href="{{ route('support.index') }}#faq">سوالات متداول</a></li>
                    <li><a href="{{ route('support.index') }}#contact">تماس با ما</a></li>
                </ul>
            </div>
        </div>
        <div class="footer-bottom">
            © ۱۴۰۳ کتابستان - تمامی حقوق محفوظ است.
        </div>
    </div>
</footer>