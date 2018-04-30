<div class="breadcrumbs">
  <div class="col-sm-4">
    <div class="page-header float-left">
      <div class="page-title">
        <h1>Dashboard</h1>
      </div>
    </div>
  </div>
  <div class="col-sm-8">
    <div class="page-header float-right">
      <div class="page-title">
        <ol class="breadcrumb text-right">
          <li><a href="#">Dashboard</a></li>
          <li><a href="#">Forms</a></li>
          <li class="active">Basic</li>
        </ol>
      </div>
    </div>
  </div>
</div>
<div class="content mt-3">
  <div class="animated fadeIn">
    <div class="row">
      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <strong>Basic Form</strong> Elements
          </div>
          <div class="card-body card-block">
            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
              <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label">Static</label></div>
                <div class="col-12 col-md-9">
                  <p class="form-control-static">Username</p>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="text-input" class=" form-control-label">Text Input</label></div>
                <div class="col-12 col-md-9"><input type="text" id="text-input" name="text-input" placeholder="Text" class="form-control"><small class="form-text text-muted">This is a help text</small></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="email-input" class=" form-control-label">Email Input</label></div>
                <div class="col-12 col-md-9"><input type="email" id="email-input" name="email-input" placeholder="Enter Email" class="form-control"><small class="help-block form-text">Please enter your email</small></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="password-input" class=" form-control-label">Password</label></div>
                <div class="col-12 col-md-9"><input type="password" id="password-input" name="password-input" placeholder="Password" class="form-control"><small class="help-block form-text">Please enter a complex password</small></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="disabled-input" class=" form-control-label">Disabled Input</label></div>
                <div class="col-12 col-md-9"><input type="text" id="disabled-input" name="disabled-input" placeholder="Disabled" disabled="" class="form-control"></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="textarea-input" class=" form-control-label">Textarea</label></div>
                <div class="col-12 col-md-9"><textarea name="textarea-input" id="textarea-input" rows="9" placeholder="Content..." class="form-control"></textarea></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="select" class=" form-control-label">Select</label></div>
                <div class="col-12 col-md-9">
                  <select name="select" id="select" class="form-control">
                    <option value="0">Please select</option>
                    <option value="1">Option #1</option>
                    <option value="2">Option #2</option>
                    <option value="3">Option #3</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="selectLg" class=" form-control-label">Select Large</label></div>
                <div class="col-12 col-md-9">
                  <select name="selectLg" id="selectLg" class="form-control-lg form-control">
                    <option value="0">Please select</option>
                    <option value="1">Option #1</option>
                    <option value="2">Option #2</option>
                    <option value="3">Option #3</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="selectSm" class=" form-control-label">Select Small</label></div>
                <div class="col-12 col-md-9">
                  <select name="selectSm" id="SelectLm" class="form-control-sm form-control">
                    <option value="0">Please select</option>
                    <option value="1">Option #1</option>
                    <option value="2">Option #2</option>
                    <option value="3">Option #3</option>
                    <option value="4">Option #4</option>
                    <option value="5">Option #5</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="disabledSelect" class=" form-control-label">Disabled Select</label></div>
                <div class="col-12 col-md-9">
                  <select name="disabledSelect" id="disabledSelect" disabled="" class="form-control">
                    <option value="0">Please select</option>
                    <option value="1">Option #1</option>
                    <option value="2">Option #2</option>
                    <option value="3">Option #3</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="multiple-select" class=" form-control-label">Multiple select</label></div>
                <div class="col col-md-9">
                  <select name="multiple-select" id="multiple-select" multiple="" class="form-control">
                    <option value="1">Option #1</option>
                    <option value="2">Option #2</option>
                    <option value="3">Option #3</option>
                    <option value="4">Option #4</option>
                    <option value="5">Option #5</option>
                    <option value="6">Option #6</option>
                    <option value="7">Option #7</option>
                    <option value="8">Option #8</option>
                    <option value="9">Option #9</option>
                    <option value="10">Option #10</option>
                  </select>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label">Radios</label></div>
                <div class="col col-md-9">
                  <div class="form-check">
                    <div class="radio">
                      <label for="radio1" class="form-check-label ">
                        <input type="radio" id="radio1" name="radios" value="option1" class="form-check-input">Option 1
                      </label>
                    </div>
                    <div class="radio">
                      <label for="radio2" class="form-check-label ">
                        <input type="radio" id="radio2" name="radios" value="option2" class="form-check-input">Option 2
                      </label>
                    </div>
                    <div class="radio">
                      <label for="radio3" class="form-check-label ">
                        <input type="radio" id="radio3" name="radios" value="option3" class="form-check-input">Option 3
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label">Inline Radios</label></div>
                <div class="col col-md-9">
                  <div class="form-check-inline form-check">
                    <label for="inline-radio1" class="form-check-label ">
                      <input type="radio" id="inline-radio1" name="inline-radios" value="option1" class="form-check-input">One
                    </label>
                    <label for="inline-radio2" class="form-check-label ">
                      <input type="radio" id="inline-radio2" name="inline-radios" value="option2" class="form-check-input">Two
                    </label>
                    <label for="inline-radio3" class="form-check-label ">
                      <input type="radio" id="inline-radio3" name="inline-radios" value="option3" class="form-check-input">Three
                    </label>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label">Checkboxes</label></div>
                <div class="col col-md-9">
                  <div class="form-check">
                    <div class="checkbox">
                      <label for="checkbox1" class="form-check-label ">
                        <input type="checkbox" id="checkbox1" name="checkbox1" value="option1" class="form-check-input">Option 1
                      </label>
                    </div>
                    <div class="checkbox">
                      <label for="checkbox2" class="form-check-label ">
                        <input type="checkbox" id="checkbox2" name="checkbox2" value="option2" class="form-check-input"> Option 2
                      </label>
                    </div>
                    <div class="checkbox">
                      <label for="checkbox3" class="form-check-label ">
                        <input type="checkbox" id="checkbox3" name="checkbox3" value="option3" class="form-check-input"> Option 3
                      </label>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label class=" form-control-label">Inline Checkboxes</label></div>
                <div class="col col-md-9">
                  <div class="form-check-inline form-check">
                    <label for="inline-checkbox1" class="form-check-label ">
                      <input type="checkbox" id="inline-checkbox1" name="inline-checkbox1" value="option1" class="form-check-input">One
                    </label>
                    <label for="inline-checkbox2" class="form-check-label ">
                      <input type="checkbox" id="inline-checkbox2" name="inline-checkbox2" value="option2" class="form-check-input">Two
                    </label>
                    <label for="inline-checkbox3" class="form-check-label ">
                      <input type="checkbox" id="inline-checkbox3" name="inline-checkbox3" value="option3" class="form-check-input">Three
                    </label>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="file-input" class=" form-control-label">File input</label></div>
                <div class="col-12 col-md-9"><input type="file" id="file-input" name="file-input" class="form-control-file"></div>
              </div>
              <div class="row form-group">
                <div class="col col-md-3"><label for="file-multiple-input" class=" form-control-label">Multiple File input</label></div>
                <div class="col-12 col-md-9"><input type="file" id="file-multiple-input" name="file-multiple-input" multiple="" class="form-control-file"></div>
              </div>
            </form>
          </div>
          <div class="card-footer">
            <button type="submit" class="btn btn-primary btn-sm">
              <i class="fa fa-dot-circle-o"></i> Submit
            </button>
            <button type="reset" class="btn btn-danger btn-sm">
              <i class="fa fa-ban"></i> Reset
            </button>
          </div>
        </div>
      </div><!-- col-lg-6 -->

      <div class="col-lg-6">
        <div class="card">
          <div class="card-header">
            <strong class="card-title">Data Table</strong>
          </div>
          <div class="col-md-6">

            <select name="select" id="select" class="form-control btn btn-outline-primary btn-block">
              <option value="0">Please select</option>
              <option value="1">Option #1</option>
              <option value="2">Option #2</option>
              <option value="3">Option #3</option>
            </select>
          </div>
          <div class="card-body">
            <table id="bootstrap-data-table" class="table table-striped table-bordered">
              <thead>
                <tr>
                  <th id="name">Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Salary</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Tiger Nixon</td>
                  <td>System Architect</td>
                  <td>Edinburgh</td>
                  <td>$320,800</td>
                </tr>
                <tr>
                  <td>Garrett Winters</td>
                  <td>Accountant</td>
                  <td>Tokyo</td>
                  <td>$170,750</td>
                </tr>
                <tr>
                  <td>Ashton Cox</td>
                  <td>Junior Technical Author</td>
                  <td>San Francisco</td>
                  <td>$86,000</td>
                </tr>
                <tr>
                  <td>Cedric Kelly</td>
                  <td>Senior Javascript Developer</td>
                  <td>Edinburgh</td>
                  <td>$433,060</td>
                </tr>
                <tr>
                  <td>Airi Satou</td>
                  <td>Accountant</td>
                  <td>Tokyo</td>
                  <td>$162,700</td>
                </tr>
                <tr>
                  <td>Brielle Williamson</td>
                  <td>Integration Specialist</td>
                  <td>New York</td>
                  <td>$372,000</td>
                </tr>
                <tr>
                  <td>Herrod Chandler</td>
                  <td>Sales Assistant</td>
                  <td>San Francisco</td>
                  <td>$137,500</td>
                </tr>
                <tr>
                  <td>Rhona Davidson</td>
                  <td>Integration Specialist</td>
                  <td>Tokyo</td>
                  <td>$327,900</td>
                </tr>
                <tr>
                  <td>Colleen Hurst</td>
                  <td>Javascript Developer</td>
                  <td>San Francisco</td>
                  <td>$205,500</td>
                </tr>
                <tr>
                  <td>Sonya Frost</td>
                  <td>Software Engineer</td>
                  <td>Edinburgh</td>
                  <td>$103,600</td>
                </tr>
                <tr>
                  <td>Jena Gaines</td>
                  <td>Office Manager</td>
                  <td>London</td>
                  <td>$90,560</td>
                </tr>
                <tr>
                  <td>Quinn Flynn</td>
                  <td>Support Lead</td>
                  <td>Edinburgh</td>
                  <td>$342,000</td>
                </tr>
                <tr>
                  <td>Charde Marshall</td>
                  <td>Regional Director</td>
                  <td>San Francisco</td>
                  <td>$470,600</td>
                </tr>
                <tr>
                  <td>Haley Kennedy</td>
                  <td>Senior Marketing Designer</td>
                  <td>London</td>
                  <td>$313,500</td>
                </tr>
                <tr>
                  <td>Tatyana Fitzpatrick</td>
                  <td>Regional Director</td>
                  <td>London</td>
                  <td>$385,750</td>
                </tr>
                <tr>
                  <td>Michael Silva</td>
                  <td>Marketing Designer</td>
                  <td>London</td>
                  <td>$198,500</td>
                </tr>
                <tr>
                  <td>Paul Byrd</td>
                  <td>Chief Financial Officer (CFO)</td>
                  <td>New York</td>
                  <td>$725,000</td>
                </tr>
                <tr>
                  <td>Gloria Little</td>
                  <td>Systems Administrator</td>
                  <td>New York</td>
                  <td>$237,500</td>
                </tr>
                <tr>
                  <td>Bradley Greer</td>
                  <td>Software Engineer</td>
                  <td>London</td>
                  <td>$132,000</td>
                </tr>
                <tr>
                  <td>Dai Rios</td>
                  <td>Personnel Lead</td>
                  <td>Edinburgh</td>
                  <td>$217,500</td>
                </tr>
                <tr>
                  <td>Jenette Caldwell</td>
                  <td>Development Lead</td>
                  <td>New York</td>
                  <td>$345,000</td>
                </tr>
                <tr>
                  <td>Yuri Berry</td>
                  <td>Chief Marketing Officer (CMO)</td>
                  <td>New York</td>
                  <td>$675,000</td>
                </tr>
                <tr>
                  <td>Caesar Vance</td>
                  <td>Pre-Sales Support</td>
                  <td>New York</td>
                  <td>$106,450</td>
                </tr>
                <tr>
                  <td>Doris Wilder</td>
                  <td>Sales Assistant</td>
                  <td>Sidney</td>
                  <td>$85,600</td>
                </tr>
                <tr>
                  <td>Angelica Ramos</td>
                  <td>Chief Executive Officer (CEO)</td>
                  <td>London</td>
                  <td>$1,200,000</td>
                </tr>
                <tr>
                  <td>Gavin Joyce</td>
                  <td>Developer</td>
                  <td>Edinburgh</td>
                  <td>$92,575</td>
                </tr>
                <tr>
                  <td>Jennifer Chang</td>
                  <td>Regional Director</td>
                  <td>Singapore</td>
                  <td>$357,650</td>
                </tr>
                <tr>
                  <td>Brenden Wagner</td>
                  <td>Software Engineer</td>
                  <td>San Francisco</td>
                  <td>$206,850</td>
                </tr>
                <tr>
                  <td>Fiona Green</td>
                  <td>Chief Operating Officer (COO)</td>
                  <td>San Francisco</td>
                  <td>$850,000</td>
                </tr>
                <tr>
                  <td>Shou Itou</td>
                  <td>Regional Marketing</td>
                  <td>Tokyo</td>
                  <td>$163,000</td>
                </tr>
                <tr>
                  <td>Michelle House</td>
                  <td>Integration Specialist</td>
                  <td>Sidney</td>
                  <td>$95,400</td>
                </tr>
                <tr>
                  <td>Suki Burks</td>
                  <td>Developer</td>
                  <td>London</td>
                  <td>$114,500</td>
                </tr>
                <tr>
                  <td>Prescott Bartlett</td>
                  <td>Technical Author</td>
                  <td>London</td>
                  <td>$145,000</td>
                </tr>
                <tr>
                  <td>Gavin Cortez</td>
                  <td>Team Leader</td>
                  <td>San Francisco</td>
                  <td>$235,500</td>
                </tr>
                <tr>
                  <td>Martena Mccray</td>
                  <td>Post-Sales support</td>
                  <td>Edinburgh</td>
                  <td>$324,050</td>
                </tr>
                <tr>
                  <td>Unity Butler</td>
                  <td>Marketing Designer</td>
                  <td>San Francisco</td>
                  <td>$85,675</td>
                </tr>
                <tr>
                  <td>Howard Hatfield</td>
                  <td>Office Manager</td>
                  <td>San Francisco</td>
                  <td>$164,500</td>
                </tr>
                <tr>
                  <td>Hope Fuentes</td>
                  <td>Secretary</td>
                  <td>San Francisco</td>
                  <td>$109,850</td>
                </tr>
                <tr>
                  <td>Vivian Harrell</td>
                  <td>Financial Controller</td>
                  <td>San Francisco</td>
                  <td>$452,500</td>
                </tr>
                <tr>
                  <td>Timothy Mooney</td>
                  <td>Office Manager</td>
                  <td>London</td>
                  <td>$136,200</td>
                </tr>
                <tr>
                  <td>Jackson Bradshaw</td>
                  <td>Director</td>
                  <td>New York</td>
                  <td>$645,750</td>
                </tr>
                <tr>
                  <td>Olivia Liang</td>
                  <td>Support Engineer</td>
                  <td>Singapore</td>
                  <td>$234,500</td>
                </tr>
                <tr>
                  <td>Bruno Nash</td>
                  <td>Software Engineer</td>
                  <td>London</td>
                  <td>$163,500</td>
                </tr>
                <tr>
                  <td>Sakura Yamamoto</td>
                  <td>Support Engineer</td>
                  <td>Tokyo</td>
                  <td>$139,575</td>
                </tr>
                <tr>
                  <td>Thor Walton</td>
                  <td>Developer</td>
                  <td>New York</td>
                  <td>$98,540</td>
                </tr>
                <tr>
                  <td>Finn Camacho</td>
                  <td>Support Engineer</td>
                  <td>San Francisco</td>
                  <td>$87,500</td>
                </tr>
                <tr>
                  <td>Serge Baldwin</td>
                  <td>Data Coordinator</td>
                  <td>Singapore</td>
                  <td>$138,575</td>
                </tr>
                <tr>
                  <td>Zenaida Frank</td>
                  <td>Software Engineer</td>
                  <td>New York</td>
                  <td>$125,250</td>
                </tr>
                <tr>
                  <td>Zorita Serrano</td>
                  <td>Software Engineer</td>
                  <td>San Francisco</td>
                  <td>$115,000</td>
                </tr>
                <tr>
                  <td>Jennifer Acosta</td>
                  <td>Junior Javascript Developer</td>
                  <td>Edinburgh</td>
                  <td>$75,650</td>
                </tr>
                <tr>
                  <td>Cara Stevens</td>
                  <td>Sales Assistant</td>
                  <td>New York</td>
                  <td>$145,600</td>
                </tr>
                <tr>
                  <td>Hermione Butler</td>
                  <td>Regional Director</td>
                  <td>London</td>
                  <td>$356,250</td>
                </tr>
                <tr>
                  <td>Lael Greer</td>
                  <td>Systems Administrator</td>
                  <td>London</td>
                  <td>$103,500</td>
                </tr>
                <tr>
                  <td>Jonas Alexander</td>
                  <td>Developer</td>
                  <td>San Francisco</td>
                  <td>$86,500</td>
                </tr>
                <tr>
                  <td>Shad Decker</td>
                  <td>Regional Director</td>
                  <td>Edinburgh</td>
                  <td>$183,000</td>
                </tr>
                <tr>
                  <td>Michael Bruce</td>
                  <td>Javascript Developer</td>
                  <td>Singapore</td>
                  <td>$183,000</td>
                </tr>
                <tr>
                  <td>Donna Snider</td>
                  <td>Customer Support</td>
                  <td>New York</td>
                  <td>$112,000</td>
                </tr>
              </tbody>
            </table>
          </div><!-- card-body -- >
        </div><!-- card -->
      </div><!-- col-lg-6 -->
    </div><!-- .row -->
  </div><!-- .animated -->
</div><!-- .content -->
