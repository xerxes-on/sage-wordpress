<div class="w-full h-fit flex items-center justify-center">
  <form id="time-locale-form"
        class="bg-violet-400 py-3 px-10 flex flex-col justify-between items-center w-fit h-fit rounded-2xl">
    <select name="locale" id="locale-select" class="rounded-2xl h-10 my-5 text-center">
      <option value="Asia/Tashkent">Tashkent </option>
      <option value="Europe/Moscow">Moscow</option>
      <option value="Europe/Minsk">Minsk</option>
      <option value="Asia/Tokyo">Tokyo</option>
      <option value="America/New_York">New_York</option>
    </select>
    <input type="text" id="time-result" readonly placeholder="Result here..."
           class="w-48 rounded-2xl h-10 my-5 pl-5">
    <button type="submit" class="bold rounded-2xl hover:text-black px-4 py-2 text-white text-xl hover:bg-amber-200">Get Time</button>
  </form>
</div>




