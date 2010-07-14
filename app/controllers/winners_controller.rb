class WinnersController < ApplicationController
  def index
    @winners = Winner.order("created_at DESC")

    respond_to do |format|
      format.html # index.html.erb
      format.xml  { render :xml => @winners }
    end
  end
  
  def new
    @winner = Winner.new
    
    respond_to do |format|
      format.html # new.html.erb
      format.xml  { render :xml => @reward }
    end
  end
  
  def create
    @winner = Winner.new(params[:winner])
    
    respond_to do |format|
      if @winner.save
        format.html do
          choose_reward
          redirect_to('/winners', :notice => @winner.nick+' wygrywa '+@reward.name+'.')
        end
        format.xml  { render :xml => @winner, :status => :created, :location => @winner }
      else
        format.html { render :action => "new" }
        format.xml  { render :xml => @winner.errors, :status => :unprocessable_entity }
      end
    end
  end
  
  def choose_reward
    available_rewards = Reward.where(["? > ?", @winner.fraction, 0])
    array = []
    available_rewards.each do |reward|
      howmany = reward.rate * reward.ally if @winner.fraction == 'ally'
      howmany = reward.rate * reward.horda if @winner.fraction == 'horda'
      howmany = 10 if howmany > 10
      howmany.times do
        array.push(reward.id)
      end
    end
    array.shuffle
    @reward = Reward.find(array[rand(array.size)])
    @reward.ally = @reward.ally - 1 if @winner.fraction == 'ally'
    @reward.horda = @reward.horda - 1 if @winner.fraction == 'horda'
    @reward.save
    @winner.reward = @reward
    @winner.save
  end
end
