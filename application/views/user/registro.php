<main><br><br>
  <div class="container mt-5">
    <div class="row justify-content-center">
      <div class="col-md-6 home-div-card">
        <form id="loginForm">
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-5 text-center">
            <h4 class="modal-title fw-bold" id="">Crear cuenta</h4>
          </div>
          <div class="form-floating mb-3">
            <input type="text" class="form-control" id="floatName" placeholder="name@example.com">
            <label for="floatName">Nombres y Apellidos</label>
          </div>

          <div class="form-floating mb-3">
            <input type="text" inputmode="tel" class="form-control" id="floatPhone" placeholder="name@example.com">
            <label for="floatPhone">Celular</label>
          </div>

          <div class="row">
            <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
              <label class="fw-bold mb-2">Departamento <span class="label-advertencia text-danger"> *</span></label>
              <div class="form-group">
                <select name="cbo-departamento" id="cbo-departamento" class="form-select">
                  <option value="0" selected="selected">- Seleccionar -</option>
                </select>
              </div>
              <span class="help-block text-danger" id="error"></span>
            </div>

            <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
              <label class="fw-bold mb-2">Provincia <span class="label-advertencia text-danger"> *</span></label>
              <div class="form-group">
                <select name="cbo-provincia" id="cbo-provincia" class="form-select">
                  <option value="0" selected="selected">- Seleccionar -</option>
                </select>
              </div>
              <span class="help-block text-danger" id="error"></span>
            </div>

            <div class="col-12 col-sm-4 col-md-6 col-lg-4 mb-4">
              <label class="fw-bold mb-2">Distrito <span class="label-advertencia text-danger"> *</span></label>
              <div class="form-group">
                <select name="cbo-distrito" id="cbo-distrito" class="form-select">
                  <option value="0" selected="selected">- Seleccionar -</option>
                </select>
              </div>
              <span class="help-block text-danger" id="error"></span>
            </div>
          </div>

          <div class="form-floating mb-3">
            <input type="email" inputmode="email" class="form-control" id="floatEmail" placeholder="name@example.com">
            <label for="floatEmail">Email</label>
          </div>

          <div class="form-floating mb-5">
            <input type="password" inputmode="password" class="form-control" id="floatPassword" placeholder="name@example.com">
            <label for="floatPassword">Password</label>
          </div>
          
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
            <button type="button" class="w-100 btn btn-success btn-lg">Crear cuenta</button>
          </div>
            
          <div class="col-12 col-sm-12 col-md-12 col-lg-12 mb-3">
            <a type="button" href="<?php echo base_url(""); ?>" rel="noopener noreferrer" class="w-100 btn btn-link btn-lg text-decoration-none">Seguir comprando</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</main>