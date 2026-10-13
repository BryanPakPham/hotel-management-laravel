
// =========================================
// 1. XỬ LÝ FORM TÌM PHÒNG
// =========================================

document.addEventListener("DOMContentLoaded", function () {
    const bookingForm = document.getElementById("bookingSearchForm");
    const checkinInput = document.getElementById("checkin");
    const checkoutInput = document.getElementById("checkout");
    const bookingMessage = document.getElementById("bookingMessage");

    // Chuyển ngày hiện tại thành YYYY-MM-DD theo giờ địa phương.
    function getLocalDateString(date) {
        const year = date.getFullYear();
        const month = String(date.getMonth() + 1).padStart(2, "0");
        const day = String(date.getDate()).padStart(2, "0");

        return `${year}-${month}-${day}`;
    }

    function addDays(dateString, numberOfDays) {
        const date = new Date(dateString + "T12:00:00");
        date.setDate(date.getDate() + numberOfDays);

        return getLocalDateString(date);
    }

    if (bookingForm && checkinInput && checkoutInput) {
        const today = getLocalDateString(new Date());

        // Không cho chọn ngày trong quá khứ.
        checkinInput.min = today;
        checkoutInput.min = addDays(today, 1);

        // Giá trị mặc định: nhận phòng hôm nay, trả phòng ngày mai.
        if (!checkinInput.value) {
            checkinInput.value = today;
        }

        if (!checkoutInput.value) {
            checkoutInput.value = addDays(today, 1);
        }

        function updateCheckoutMin() {
            if (!checkinInput.value) {
                checkoutInput.min = addDays(today, 1);
                return;
            }

            checkoutInput.min = addDays(checkinInput.value, 1);

            // Nếu ngày trả phòng không hợp lệ, tự điều chỉnh sang ngày kế tiếp.
            if (
                !checkoutInput.value ||
                checkoutInput.value <= checkinInput.value
            ) {
                checkoutInput.value = checkoutInput.min;
            }
        }

        checkinInput.addEventListener("change", function () {
            updateCheckoutMin();

            if (bookingMessage) {
                bookingMessage.textContent = "";
            }
        });

        checkoutInput.addEventListener("change", function () {
            if (bookingMessage) {
                bookingMessage.textContent = "";
            }
        });

        bookingForm.addEventListener("submit", function (event) {
            const checkin = checkinInput.value;
            const checkout = checkoutInput.value;

            if (!checkin || !checkout) {
                event.preventDefault();

                if (bookingMessage) {
                    bookingMessage.textContent =
                        "Vui lòng chọn ngày nhận phòng và trả phòng.";
                }

                return;
            }

            if (checkin < today) {
                event.preventDefault();

                if (bookingMessage) {
                    bookingMessage.textContent =
                        "Ngày nhận phòng không được nằm trong quá khứ.";
                }

                checkinInput.focus();
                return;
            }

            if (checkout <= checkin) {
                event.preventDefault();

                if (bookingMessage) {
                    bookingMessage.textContent =
                        "Ngày trả phòng phải sau ngày nhận phòng.";
                }

                checkoutInput.focus();
            }

            // Form hợp lệ sẽ gửi GET đến trang chủ kèm query string.
            // Đây mới là giao diện tìm kiếm, chưa truy vấn phòng thật.
        });
    }


    // =========================================
    // 2. ĐIỀU KHIỂN VIDEO GIỚI THIỆU
    // =========================================

    const videoGallery = document.getElementById("hotelVideoGallery");

    if (!videoGallery) {
        return;
    }

    const slides = Array.from(
        videoGallery.querySelectorAll(".video-slide")
    );

    const dots = Array.from(
        videoGallery.querySelectorAll(".video-dot")
    );

    const prevButton = document.getElementById("videoPrev");
    const nextButton = document.getElementById("videoNext");

    let currentVideoIndex = 0;

    // Kiểm tra video đã có nguồn thật hay chưa.
    function hasVideoSource(video) {
        const directSource = video.getAttribute("src");

        const sourceElement = video.querySelector("source[src]");
        const nestedSource = sourceElement
            ? sourceElement.getAttribute("src")
            : "";

        return Boolean(
            (directSource && directSource.trim()) ||
            (nestedSource && nestedSource.trim())
        );
    }

    // Ẩn placeholder khi video đã có nguồn.
    function updateVideoPlaceholder(slide) {
        const video = slide.querySelector(".hotel-video");
        const placeholder = slide.querySelector(".video-placeholder");

        if (!video || !placeholder) {
            return;
        }

        placeholder.hidden = hasVideoSource(video);
    }

    // Chuyển đến video theo chỉ số.
    function showVideo(index) {
        if (slides.length === 0) {
            return;
        }

        // Quay vòng khi đến video cuối hoặc đầu.
        currentVideoIndex = (index + slides.length) % slides.length;

        slides.forEach(function (slide, slideIndex) {
            const video = slide.querySelector(".hotel-video");

            // Dừng video cũ trước khi chuyển.
            if (video) {
                video.pause();
            }

            const isActive = slideIndex === currentVideoIndex;

            slide.hidden = !isActive;
            slide.classList.toggle("is-active", isActive);

            updateVideoPlaceholder(slide);
        });

        dots.forEach(function (dot, dotIndex) {
            const isActive = dotIndex === currentVideoIndex;

            dot.classList.toggle("is-active", isActive);

            if (isActive) {
                dot.setAttribute("aria-current", "true");
            } else {
                dot.removeAttribute("aria-current");
            }
        });
    }

    if (prevButton) {
        prevButton.addEventListener("click", function () {
            showVideo(currentVideoIndex - 1);
        });
    }

    if (nextButton) {
        nextButton.addEventListener("click", function () {
            showVideo(currentVideoIndex + 1);
        });
    }

    dots.forEach(function (dot) {
        dot.addEventListener("click", function () {
            const targetIndex = Number(dot.dataset.videoTarget);

            if (Number.isInteger(targetIndex)) {
                showVideo(targetIndex);
            }
        });
    });

    // Khởi tạo video đầu tiên.
    showVideo(0);
});
