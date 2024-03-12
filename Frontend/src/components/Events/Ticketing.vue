<!-- eslint-disable vue/multi-word-component-names -->
<template>
    <div class="container  mb-5">

        <div class="row ">
            <!-- Ticekt Info -->
            <div class="col-lg-5 col-md-12 col-sm-12  mb-4">
                <div class="container">
                    <h6 class="fw-bold">Ticket Info</h6>

                    <div class="form-floating mb-3">
                        <select class="form-select" id="floatingSelect" aria-label="Floating label select example">
                          <option selected>Open this select menu</option>
                          <option value="1">One</option>
                          <option value="2">Two</option>
                          <option value="3">Three</option>
                        </select>
                        <label for="floatingSelect">Works with selects</label>
                    </div>
                    <!-- Event Price Update -->
                    <div class="form-floating input-group mb-3">
                        <input type="number" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">Update</button>
                        <label for="floatingInput">Special label </label>
                    </div>
                    <!-- Special Label -->
                    <div class="form-floating input-group mb-3">
                        <input type="text" class="form-control" id="floatingInput" placeholder="name@example.com">
                        <button class="btn btn-outline-secondary" type="button" id="button-addon1">Update</button>
                        <label for="floatingInput">Special label </label>
                    </div>
                </div>
            </div>
            <!-- Ticket Preview -->
            <div class="col-lg-7 col-md-12 col-sm-12  mb-4">
                <div class="card border-0 shadow ">
                    <div class="card-header border-0 text-center ">
                        <h6 class="fw-bold">Ticket Preview</h6>
                    </div>
                    <div class="card-body p-5"></div>
                </div>
            </div>
        </div>
        
    </div>
</template>