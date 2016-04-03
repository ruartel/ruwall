<div class="col-md-12 page-wp">
    <div class="col-md-4 left-page">
        <form novalidate class="loved-form" ng-submit="submitLoved();">
            <div class="pageTitle">Add a Loved One</div>
            <div class="pageSubTitle">International Memorial Wall</div>

            <div class="box-fields">
                <div class="dFlex box-line box-title-wp">
                    <div class="box-step">1</div>
                    <div class="box-title">Your info</div>
                </div>    
                <div class="dFlex box-line">
                    <div class="false-input left_input">
                        <div class="required_star"></div>
                        <input type="text" ng-model="lead.fname" placeholder="First Name" />
                    </div>
                    <div class="false-input">
                        <div class="required_star"></div>
                        <input type="text" ng-model="lead.lname" placeholder="Last Name" />
                    </div>
                </div>
                <div class="box-line">
                    <div class="false-input input_long">
                        <div class="required_star"></div>
                        <input type="email" ng-model="lead.email" placeholder="E-mail Address" />
                    </div>
                </div>
            </div>  
            <div class="box-fields">
                <div class="dFlex box-line box-title-wp">
                    <div class="box-step">2</div>
                    <div class="box-title">Submit the memory of a loved one</div>
                </div>

                <loved-fields></loved-fields>
                <div id='moreLoved'></div>

                <add-oneloved></add-oneloved>
            </div>
            <div style="margin-top: 40px;"></div>
            <input type="submit" value="Save" />
        </form>
    </div>    
    <div class="col-md-6 right-page">
        <div class="card-example">
            <div>{{user.fname}} {{user.lname}}</div>
        </div>
    </div>
</div>
