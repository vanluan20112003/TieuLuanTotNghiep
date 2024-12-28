<!-- resources/views/test.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test bs-stepper</title>
    <!-- Include Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Include bs-stepper CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bs-stepper/dist/css/bs-stepper.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div id="stepper1" class="bs-stepper">
            <div class="bs-stepper-header" role="tablist">
                <!-- Step 1 -->
                <div class="step" data-target="#step-1">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger1" aria-controls="step-1">
                        <span class="bs-stepper-circle">1</span>
                        <span class="bs-stepper-label">Step 1</span>
                    </button>
                </div>
                <div class="line"></div>
                <!-- Step 2 -->
                <div class="step" data-target="#step-2">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger2" aria-controls="step-2">
                        <span class="bs-stepper-circle">2</span>
                        <span class="bs-stepper-label">Step 2</span>
                    </button>
                </div>
                <div class="line"></div>
                <!-- Step 3 -->
                <div class="step" data-target="#step-3">
                    <button type="button" class="step-trigger" role="tab" id="stepper1trigger3" aria-controls="step-3">
                        <span class="bs-stepper-circle">3</span>
                        <span class="bs-stepper-label">Step 3</span>
                    </button>
                </div>
            </div>
            <div class="bs-stepper-content">
                <!-- Content for Step 1 -->
                <div id="step-1" class="content" role="tabpanel" aria-labelledby="stepper1trigger1">
                    <h5>Content for Step 1</h5>
                    <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                </div>
                <!-- Content for Step 2 -->
                <div id="step-2" class="content" role="tabpanel" aria-labelledby="stepper1trigger2">
                    <h5>Content for Step 2</h5>
                    <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                    <button class="btn btn-primary" onclick="stepper1.next()">Next</button>
                </div>
                <!-- Content for Step 3 -->
                <div id="step-3" class="content" role="tabpanel" aria-labelledby="stepper1trigger3">
                    <h5>Content for Step 3</h5>
                    <button class="btn btn-primary" onclick="stepper1.previous()">Previous</button>
                    <button class="btn btn-success">Finish</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Include bs-stepper JS -->
    <script src="https://cdn.jsdelivr.net/npm/bs-stepper/dist/js/bs-stepper.min.js"></script>
    <script>
        // Initialize bs-stepper
        document.addEventListener('DOMContentLoaded', function () {
            window.stepper1 = new Stepper(document.querySelector('#stepper1'));
        });
    </script>
</body>
</html>
