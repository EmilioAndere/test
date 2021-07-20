<div class="flex bg-gray-100 rounded-md my-5">
    <div class="flex w-full">
        <div class="w-1/4 md:w-2/4">
            <div class="flex">
                <label for="">Name</label>
                <span class="px-2" title="El nombre debe remplazar los espacios con '_'"><i class="fas fa-question-circle"></i></span>
            </div>
            <input type="text" id="nameTable" class="focus:outline-none px-2 py-1" placeholder="Name of Device">
        </div>
        <div class="flex justify-end w-3/4">
            <div id="attribute" class="mx-2 text-center bg-blue-300 hover:bg-blue-500 py-3 px-1 rounded-md cursor-pointer">
                <i class="fas fa-list-ul"></i>
                <p class="text-xs">New Attribute</p>
            </div>
            <div id="createDevice" class="mx-2 text-center bg-green-300 hover:bg-green-500 py-3 px-1 rounded-md cursor-pointer">
                <i class="fas fa-laptop-medical"></i>
                <p class="text-xs">Create Device</p>
            </div>
            <div id="cancel" class="mx-2 text-center bg-red-300 hover:bg-red-500 p-3 rounded-md cursor-pointer">
                <i class="fas fa-ban"></i>
                <p class="text-xs">Cancel</p>
            </div>
        </div>
    </div>
</div>