document.addEventListener('DOMContentLoaded', function () {
    const mapWrapper = document.getElementById('map-wrapper');
    const mapImg = document.getElementById('map-img');
    const toggleBtn = document.getElementById('toggle-map-view');
    const zoomInBtn = document.getElementById('zoom-in');
    const zoomOutBtn = document.getElementById('zoom-out');
    const resetBtn = document.getElementById('reset-map');

    let isFullView = false;
    let isDragging = false;
    let startX = 0, startY = 0;
    let panX = 0, panY = 0;
    let zoom = 1.0;

    // Apply translation and zoom transform to the image
    function applyTransform(withTransition = false) {
        if (withTransition) {
            mapImg.style.transition = 'transform 0.4s cubic-bezier(0.16, 1, 0.3, 1)';
        } else {
            mapImg.style.transition = 'none';
        }
        mapImg.style.transform = `translate3d(${panX}px, ${panY}px, 0) scale(${zoom})`;
    }

    // Toggle view
    toggleBtn.addEventListener('click', function () {
        isFullView = !isFullView;
        if (isFullView) {
            mapWrapper.classList.add('full-view');
            toggleBtn.innerHTML = '<span class="material-symbols-outlined">legend_toggle</span> Show Cropped Map';
            mapImg.style.transform = '';
            mapImg.style.transition = '';
        } else {
            mapWrapper.classList.remove('full-view');
            toggleBtn.innerHTML = '<span class="material-symbols-outlined">legend_toggle</span> Show Full Map & Legend';
            // Reset values
            panX = 0;
            panY = 0;
            zoom = 1.0;
            applyTransform(true);
        }
    });

    // Zoom Controls
    zoomInBtn.addEventListener('click', function () {
        if (isFullView) return;
        zoom = Math.min(zoom + 0.25, 3.0);
        applyTransform(true);
    });

    zoomOutBtn.addEventListener('click', function () {
        if (isFullView) return;
        zoom = Math.max(zoom - 0.25, 0.75);
        applyTransform(true);
    });

    resetBtn.addEventListener('click', function () {
        if (isFullView) return;
        panX = 0;
        panY = 0;
        zoom = 1.0;
        applyTransform(true);
    });

    // Drag handling (Mouse)
    mapImg.addEventListener('mousedown', function (e) {
        if (isFullView) return;
        isDragging = true;
        mapImg.style.cursor = 'grabbing';

        // Disable transitions during dragging for real-time responsiveness
        mapImg.style.transition = 'none';

        startX = e.clientX - panX;
        startY = e.clientY - panY;
        e.preventDefault();
    });

    window.addEventListener('mousemove', function (e) {
        if (!isDragging || isFullView) return;

        panX = e.clientX - startX;
        panY = e.clientY - startY;

        // Apply boundaries to prevent dragging the map completely away
        const wrapperRect = mapWrapper.getBoundingClientRect();
        const imgRect = mapImg.getBoundingClientRect();

        // Calculate limits: don't let map go completely out of the wrapper
        const maxPanX = imgRect.width * 0.6;
        const maxPanY = imgRect.height * 0.6;

        panX = Math.min(Math.max(panX, -maxPanX), maxPanX);
        panY = Math.min(Math.max(panY, -maxPanY), maxPanY);

        applyTransform(false);
    });

    window.addEventListener('mouseup', function () {
        if (isDragging) {
            isDragging = false;
            mapImg.style.cursor = 'grab';
        }
    });

    // Drag handling (Touch for Mobile Devices)
    mapImg.addEventListener('touchstart', function (e) {
        if (isFullView) return;
        isDragging = true;
        mapImg.style.transition = 'none';

        const touch = e.touches[0];
        startX = touch.clientX - panX;
        startY = touch.clientY - panY;
    });

    window.addEventListener('touchmove', function (e) {
        if (!isDragging || isFullView) return;

        const touch = e.touches[0];
        panX = touch.clientX - startX;
        panY = touch.clientY - startY;

        const maxPanX = mapImg.offsetWidth * 0.8;
        const maxPanY = mapImg.offsetHeight * 0.8;

        panX = Math.min(Math.max(panX, -maxPanX), maxPanX);
        panY = Math.min(Math.max(panY, -maxPanY), maxPanY);

        applyTransform(false);
        e.preventDefault(); // prevent scrolling while dragging map
    }, { passive: false });

    window.addEventListener('touchend', function () {
        isDragging = false;
    });

    // Wheel Zoom handling
    mapWrapper.addEventListener('wheel', function (e) {
        if (isFullView) return;
        e.preventDefault();

        const zoomSpeed = 0.05;
        if (e.deltaY < 0) {
            zoom = Math.min(zoom + zoomSpeed, 3.0);
        } else {
            zoom = Math.max(zoom - zoomSpeed, 0.75);
        }
        applyTransform(true);
    }, { passive: false });
});
